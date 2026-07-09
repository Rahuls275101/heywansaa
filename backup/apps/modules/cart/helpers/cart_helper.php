<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
if (!function_exists('CI')) {

  function CI() {
    if (!function_exists('get_instance'))
      return FALSE;
    $CI = & get_instance();
    return $CI;
  }

}
function invoice_content_print_by_vendor($ordmaster, $orddetail, $type = 'user') {
  //trace($orddetail);
  $ci = CI();
  $ci->load->helper('words');
  $curr_symbol = display_symbol();
//   $grandTotal = $ordmaster['total_amount']+$ordmaster['vat_amount'];
   $grandTotal = $ordmaster['total_amount'];
  $wordsAmount = 'Rupees ';
  $wordsAmount .= getStringOfAmount($grandTotal);
  $wordsAmount .= ' Only';
  ?>

  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding:10px;">
    <tr>
      <td colspan="2" style="text-align: center;">
        <h1 style="text-align: center; font-size: 24px; padding-bottom: 30px; font-family: arial; font-weight: bold;"><?php echo ($type == 'user') ? 'Tax Invoice/Bill Of Supply/Cash Memo' : 'Order Initiated - Order Details are as Follows'; ?></h1>
      </td>
    </tr>
    <tr>
        <!---->
      <td style="padding-bottom: 30px;"><img src="<?php echo base_url(); ?>assets/sitepanel/assets/img/logo.png" class="img_responsive" width="120"></td>
      <td style="text-align: right;">
        <!-- <h1 style="margin: 0px; font-family: arial; padding: 5px 0px; width: 100%; text-align: right; font-weight:bold; font-size: 20px;">Ship To,</h1> -->
        <h2 style="margin: 0px; font-family: arial;  padding: 5px 0px; width: 100%; text-align: right; font-weight:bold; font-size: 16px;"> Billing Address:</h2>
        <h6 style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;"><?php echo $ordmaster['billing_name']; ?></h6>
        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;"><?php echo $ordmaster['billing_address']; ?>, <?php echo $ordmaster['billing_city']; ?> <?php
          echo $ordmaster['billing_state'];
          echo '<br/>Landmark: '.$ordmaster['billing_landmark'];
          echo ' , ' . $ordmaster['billing_zipcode'];
          echo ' - ' . $ordmaster['billing_country']; ?></p>
          <h2 style="margin: 0px; font-family: arial;  padding: 5px 0px; width: 100%; text-align: right; font-weight:bold; font-size: 16px;"> Shipping Address:</h2>
        <h6 style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;"><?php echo $ordmaster['shipping_name']; ?></h6>
        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;"><?php echo $ordmaster['shipping_address']; ?>, <?php echo $ordmaster['shipping_city']; ?> <?php
          echo $ordmaster['shipping_state'];
           echo '<br/>Landmark: '.$ordmaster['shipping_landmark'];
          echo ' , ' . $ordmaster['billing_zipcode'];
          echo ' - ' . $ordmaster['billing_country']; ?></p>

        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px; padding-bottom: 40px;">Contact: <?php echo $ordmaster['billing_phone']; ?><br/>Email: <?php echo $ordmaster['email']; ?></p> 
        
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <h1 style="margin: 0px; font-family: arial; padding: 5px 0px; width: 100%; text-align: left; font-weight:bold; font-size: 20px;">Sold By:</h1>
        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;">Weblieu</p>
        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;">Plot No- C-75, 4th Floor, near NIrula's Hotel, C Block, Sector 2, Noida,<br> Uttar Pradesh 201301</p>
        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px; padding-bottom: 40px;">Contact:  +91-XXXXXXXXX</p>
      </td>
    </tr>

    <tr>
      <td style="text-align: left;">
        <h1 style="font-size: 16px; font-weight:normal;"><b style="font-weight: bold; margin: 0px; padding: 0px; font-family: arial;">Order Date: </b> <?php echo getDateFormat($ordmaster['order_received_date'], 3); ?></h1>
      <td style="text-align: right;">
        <h2 style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;"><b style="font-weight: bold; font-family: arial;">Invoice Number : </b> <?php echo $ordmaster['invoice_number']; ?></h2>
        <h2 style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px; padding-bottom: 40px;"><b style="font-weight: bold; font-family: arial;">Invoice Date:</b> <?php echo getDateFormat($ordmaster['order_received_date'], 3); ?> </td>
    </tr>
    <tr>
      <td colspan="2">
        <table width="100%" border="1" cellspacing="0" cellpadding="0" style="margin: 0px; text-align: center;">
          <tr style="background: #ddd">
            <td style="border:1px solid #222; font-weight: bold; font-family: arial; font-size: 14px; padding: 10px;">SI.No</td>
            <td style="border:1px solid #222; font-weight: bold; font-family: arial; font-size: 14px; padding: 10px;">Description</td>
             <td style="border:1px solid #222; font-weight: bold; font-family: arial; font-size: 14px; padding: 10px;">Unit Price </td>
            <td style="border:1px solid #222; font-weight: bold; font-family: arial; font-size: 14px; padding: 10px;">Quantity</td>
            <td style="border:1px solid #222; font-weight: bold; font-family: arial; font-size: 14px; padding: 10px;">Total Amount</td>
          </tr>
          <?php
          $i = 1;
          $subtotal = 0;
          $total = 0;
          $toatlTax = "";
          if (is_array($orddetail) && !empty($orddetail)) 
          {
            foreach ($orddetail as $val) {
              $img = '';
              $subtotal = ( $val['quantity'] * $val['product_price']); 
              
              $total += (int)$subtotal;
              
            //   echo  $subtotal; die;
              
              $img = get_db_field_value("wps_products_media", "media", "WHERE products_id = '" . $val['products_id'] . "' ORDER BY id ASC LIMIT 0,1");
              
              
             
            if($val['size_id']>0){
                $size_name = get_db_field_value("wps_sizes", "size_name", "WHERE size_id = '" . $val['size_id'] . "'");
              }
              ?>
              <tr>

                <td><?php echo $i; ?></td>
                <td style="padding: 10px; font-family: arial; font-size: 14px;">
                  <?php
                  echo '<img style="float: left"; src="' . get_image('products', $val['product_image_name'], '100', '100', 'R') . '"/>';
                  echo $val['product_name'];

                  if($val['product_code']!=''){ echo "<br/><strong>#" . $val['product_code'] . "</strong>"; }
                  ?>
                  <?php 
                  if($val['color_id']>0)
                  {
                        echo '<br/><b>Color : </b>' .  $val['color_id'] . '';
                  }
                  if($val['size_id']>0)
                  {
                        echo '<br/><b>Size : </b>' . $val['size_id'] . ''; 
                  }
                    ?>                </td>
                 <td style="padding: 10px; font-size: 14px; font-family: arial;"><?php echo $val['product_price']; ?></td>
                <td style="padding: 10px; font-size: 14px; font-family: arial;"><?php echo $val['quantity']; ?></td>
                <td style="padding: 10px; font-size: 14px; font-family: arial;"><?php echo display_price($subtotal); ?></td>
              </tr>
              <?php
              $i++;
            }
          }
          ?>
          <?php if ($ordmaster['coupon_discount_amount'] > 0) { ?>
          <?php } ?>
          
          
           <?php if ($ordmaster['wallet_coin_use'] > 0) { ?>
          <?php } ?>

          <tr style="text-align: left; padding: 10px;">

            <td colspan="5">&nbsp;</td>
          </tr>

          <tr>

            <td colspan="9" style="padding-right: 10px;">

              <p style="font-size: 16px; font-family: arial; font-weight: bold; text-align: right; margin: 0px; padding: 5px 0px;">For Weblieu:</p>

              <div style="padding: 5px;width: 300px;background: #ddd;height: 60px;float: right;">
                  <img src="<?php echo base_url(); ?>assets/sitepanel/assets/img/logo.png" style="width: 17%;">              </div>

              <div style="clear: both;">

                <p style="font-size: 16px; font-family: arial; font-weight: bold; text-align: right; margin: 0px; padding: 5px 0px;">Authorized Signatory</p>            </td>
          </tr>
        </table>

      </td>

    </tr>

   <!--  <tr><td colspan="2" align="right"><a id="print" href="javascript:void(0);" onclick="document.getElementById('print').style.visibility = 'hidden';
          print();">Print Invoice</a></td></tr> -->

  </table>

  <?php
}


function invoice_content_print($ordmaster, $orddetail, $type = 'user') {
  //trace($orddetail);
  $ci = CI();
  $ci->load->helper('words');
  $curr_symbol = display_symbol();
//   $grandTotal = $ordmaster['total_amount']+$ordmaster['vat_amount'];
   $grandTotal = $ordmaster['total_amount'];
  $wordsAmount = 'Rupees ';
  $wordsAmount .= getStringOfAmount($grandTotal);
  $wordsAmount .= ' Only';
  ?>

  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding:10px;">
    <tr>
      <td colspan="2" style="text-align: center;">
        <h1 style="text-align: center; font-size: 24px; padding-bottom: 30px; font-family: arial; font-weight: bold;"><?php echo ($type == 'user') ? 'Tax Invoice/Bill Of Supply/Cash Memo' : 'Order Initiated - Order Details are as Follows'; ?></h1>
      </td>
    </tr>
    <tr>
        <!---->
      <td style="padding-bottom: 30px;"><img src="<?php echo base_url(); ?>assets/sitepanel/assets/img/logo.png" class="img_responsive" width="120"></td>
      <td style="text-align: right;">
        <!-- <h1 style="margin: 0px; font-family: arial; padding: 5px 0px; width: 100%; text-align: right; font-weight:bold; font-size: 20px;">Ship To,</h1> -->
        <h2 style="margin: 0px; font-family: arial;  padding: 5px 0px; width: 100%; text-align: right; font-weight:bold; font-size: 16px;"> Billing Address:</h2>
        <h6 style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;"><?php echo $ordmaster['billing_name']; ?></h6>
        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;"><?php echo $ordmaster['billing_address']; ?>, <?php echo $ordmaster['billing_city']; ?> <?php
          echo $ordmaster['billing_state'];
          echo '<br/>Landmark: '.$ordmaster['billing_landmark'];
          echo ' , ' . $ordmaster['billing_zipcode'];
          echo ' - ' . $ordmaster['billing_country']; ?></p>
          <h2 style="margin: 0px; font-family: arial;  padding: 5px 0px; width: 100%; text-align: right; font-weight:bold; font-size: 16px;"> Shipping Address:</h2>
        <h6 style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;"><?php echo $ordmaster['shipping_name']; ?></h6>
        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;"><?php echo $ordmaster['shipping_address']; ?>, <?php echo $ordmaster['shipping_city']; ?> <?php
          echo $ordmaster['shipping_state'];
           echo '<br/>Landmark: '.$ordmaster['shipping_landmark'];
          echo ' , ' . $ordmaster['billing_zipcode'];
          echo ' - ' . $ordmaster['billing_country']; ?></p>

        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px; padding-bottom: 40px;">Contact: <?php echo $ordmaster['billing_phone']; ?><br/>Email: <?php echo $ordmaster['email']; ?></p> 
        
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <h1 style="margin: 0px; font-family: arial; padding: 5px 0px; width: 100%; text-align: left; font-weight:bold; font-size: 20px;">Sold By:</h1>
        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;">Weblieu</p>
        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;">Plot No- C-75, 4th Floor, near NIrula's Hotel, C Block, Sector 2, Noida,<br> Uttar Pradesh 201301</p>
        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px; padding-bottom: 40px;">Contact:  +91-XXXXXXXXX</p>
      </td>
    </tr>

    <tr>
      <td style="text-align: left;">
        <h1 style="font-size: 16px; font-weight:normal;"><b style="font-weight: bold; margin: 0px; padding: 0px; font-family: arial;">Order Date: </b> <?php echo getDateFormat($ordmaster['order_received_date'], 3); ?></h1>
      <td style="text-align: right;">
        <h2 style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;"><b style="font-weight: bold; font-family: arial;">Invoice Number : </b> <?php echo $ordmaster['invoice_number']; ?></h2>
        <h2 style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px; padding-bottom: 40px;"><b style="font-weight: bold; font-family: arial;">Invoice Date:</b> <?php echo getDateFormat($ordmaster['order_received_date'], 3); ?> </td>
    </tr>
    <tr>
      <td colspan="2">
        <table width="100%" border="1" cellspacing="0" cellpadding="0" style="margin: 0px; text-align: center;">
          <tr style="background: #ddd">
            <td style="border:1px solid #222; font-weight: bold; font-family: arial; font-size: 14px; padding: 10px;">SI.No</td>
            <td style="border:1px solid #222; font-weight: bold; font-family: arial; font-size: 14px; padding: 10px;">Description</td>
             <td style="border:1px solid #222; font-weight: bold; font-family: arial; font-size: 14px; padding: 10px;">Unit Price </td>
            <td style="border:1px solid #222; font-weight: bold; font-family: arial; font-size: 14px; padding: 10px;">Quantity</td>
            <td style="border:1px solid #222; font-weight: bold; font-family: arial; font-size: 14px; padding: 10px;">Total Amount</td>
          </tr>
          <?php
          $i = 1;
          $subtotal = 0;
          $total = 0;
          $toatlTax = "";
          if (is_array($orddetail) && !empty($orddetail)) 
          {
            foreach ($orddetail as $val) {
              $img = '';
              $subtotal = ( $val['quantity'] * $val['product_price']); 
              
              $total += (int)$subtotal;
              
            //   echo  $subtotal; die;
              
              $img = get_db_field_value("wps_products_media", "media", "WHERE products_id = '" . $val['products_id'] . "' ORDER BY id ASC LIMIT 0,1");
              
              
             
            if($val['size_id']>0){
                $size_name = get_db_field_value("wps_sizes", "size_name", "WHERE size_id = '" . $val['size_id'] . "'");
              }
              ?>
              <tr>

                <td><?php echo $i; ?></td>
                <td style="padding: 10px; font-family: arial; font-size: 14px;">
                  <?php
                  echo '<img style="float: left"; src="' . get_image('products', $val['product_image_name'], '100', '100', 'R') . '"/>';
                  echo $val['product_name'];

                  if($val['product_code']!=''){ echo "<br/><strong>#" . $val['product_code'] . "</strong>"; }
                  ?>
                  <?php 
                  if($val['color_id']>0)
                  {
                        echo '<br/><b>Color : </b>' .  $val['color_id'] . '';
                  }
                  if($val['size_id']>0)
                  {
                        echo '<br/><b>Size : </b>' . $val['size_id'] . ''; 
                  }
                    ?>
                </td>
                 <td style="padding: 10px; font-size: 14px; font-family: arial;"><?php echo $val['product_price']; ?></td>
                <td style="padding: 10px; font-size: 14px; font-family: arial;"><?php echo $val['quantity']; ?></td>
                <td style="padding: 10px; font-size: 14px; font-family: arial;"><?php echo display_price($subtotal); ?></td>
              </tr>
              <?php
              $i++;
            }
          }
          ?>
          <tr>
            <td colspan="4" style="padding: 10px; text-align: left; font-weight: bold; font-family: arial;">Shipping Amount :</td>
            <td style="background: #ddd; font-weight: bold; font-family: arial; padding: 10px; font-size: 14px;"><?php if($ordmaster['shipping_amount']>0){ echo display_price($ordmaster['shipping_amount']); }else{ echo 'Free'; } ?></td>
          </tr>
           
          <?php if ($ordmaster['coupon_discount_amount'] > 0) { ?>
            <tr>
              <td colspan="4" style="padding: 10px; text-align: left; font-weight: bold; font-family: arial;">Coupon Discount :</td>
              <td style="background: #ddd; font-weight: bold; font-family: arial; padding: 10px; font-size: 14px;">- <?php echo display_price($ordmaster['coupon_discount_amount']); ?></td>
            </tr>
          <?php } ?>
          
          
           <?php if ($ordmaster['wallet_coin_use'] > 0) { ?>
            <tr>
              <td colspan="4" style="padding: 10px; text-align: left; font-weight: bold; font-family: arial;">Used Coins :</td>
              <td style="background: #ddd; font-weight: bold; font-family: arial; padding: 10px; font-size: 14px;">- <?php echo display_price($ordmaster['wallet_coin_use']); ?></td>
            </tr>
          <?php } ?>
          
          <tr>
            <td colspan="4" style="padding: 10px; text-align: left; font-weight: bold; font-family: arial;">Total :</td>
            <td style="background: #ddd; font-weight: bold; font-family: arial; padding: 10px; font-size: 14px;"> <?php echo display_price($grandTotal); ?></td>
          </tr>

          <tr style="text-align: left; padding: 10px;">

            <td colspan="5"><h1 style="font-size: 18px; font-family: arial; margin: 0px; font-weight:bold; text-align: left;padding: 5px 0px; padding-left: 10px;">Amount in Words:</h1>

              <h2 style="font-size: 18px; margin: 0px; font-family: arial;  font-weight:bold; text-align: left; padding: 5px 0px; padding-left: 10px;"><?php echo $wordsAmount; ?></h2> </td>

          </tr>

          <tr>

            <td colspan="9" style="padding-right: 10px;">

              <p style="font-size: 16px; font-family: arial; font-weight: bold; text-align: right; margin: 0px; padding: 5px 0px;">For Weblieu:</p>

              <div style="padding: 5px;width: 300px;background: #ddd;height: 60px;float: right;">
                  <img src="<?php echo base_url(); ?>assets/sitepanel/assets/img/logo.png" style="width: 17%;">
              </div>

              <div style="clear: both;">

                <p style="font-size: 16px; font-family: arial; font-weight: bold; text-align: right; margin: 0px; padding: 5px 0px;">Authorized Signatory</p>

            </td>

          </tr>

        </table>

      </td>

    </tr>

   <!--  <tr><td colspan="2" align="right"><a id="print" href="javascript:void(0);" onclick="document.getElementById('print').style.visibility = 'hidden';
          print();">Print Invoice</a></td></tr> -->

  </table>

  <?php
}

function invoice_content_html($ordmaster, $orddetail, $type = 'user') {
  //trace($orddetail);
  $ci = CI();
  $ci->load->helper('words');
  $curr_symbol = display_symbol();
  $grandTotal = $ordmaster['total_amount'];
  $wordsAmount = 'US Dollar ';
  $wordsAmount .= getStringOfAmount($grandTotal);
  $wordsAmount .= ' Only';
  $title = ($type == 'user') ? 'Tax Invoice/Bill Of Supply/Cash Memo' : 'Order Initiated - Order Details are as Follows';
  $var = '';
  $var.='<table width="550" border="0" cellpadding="0" cellspacing="0" style="padding:10px;">
    <tr>
      <td colspan="6" style="text-align: center;">
        <h1 style="text-align: center; font-size: 24px; padding-bottom: 30px; font-family: arial; font-weight: bold;">' . $title . '</h1>
      </td>
    </tr>
    <tr>
      <td colspan="3" style="padding-bottom: 30px;"><img src="' . FCROOT . '/assets/designer/themes/default/images/logo.png" class="img_responsive" width="120"></td>
      <td colspan="3" style="text-align: right;">
        <h1 style="margin: 0px; font-family: arial; padding: 5px 0px; width: 100%; text-align: right; font-weight:bold; font-size: 20px;">Ship To,</h1>
        <h2 style="margin: 0px; font-family: arial;  padding: 5px 0px; width: 100%; text-align: right; font-weight:bold; font-size: 16px;"> Billing Address:</h2>

        <h6 style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;">' . $ordmaster['billing_name'] . '</h6>
        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;">' . $ordmaster['billing_address'] . ', ' . $ordmaster['billing_city'] . '</p>
        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;">' . $ordmaster['billing_state'] . ' , ' . $ordmaster['billing_zipcode'] . ' - ' . $ordmaster['billing_country'] . '</p>
        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px; padding-bottom: 40px;">Contact: ' . $ordmaster['billing_phone'] . '</p>  
      </td>
    </tr>
    <tr>
      <td colspan="6">
        <h1 style="margin: 0px; font-family: arial; padding: 5px 0px; width: 100%; text-align: left; font-weight:bold; font-size: 20px;">Sold By:</h1>
        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;">Shelley Enterprises</p>
        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;">22833 Lockness Ave. Torrance CA, 90501, USA</p>
        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px; padding-bottom: 40px;">Contact:  1-800-544-5537</p>
      </td>
    </tr>

    <tr>
      <td colspan="3" style="text-align: left;">
        <h1 style="font-size: 16px; font-weight:normal;"><b style="font-weight: bold; margin: 0px; padding: 0px; font-family: arial;">Order Date: </b> ' . getDateFormat($ordmaster['order_received_date'], 3) . '</h1>
      <td colspan="3" style="text-align: right;">
        <h2 style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;"><b style="font-weight: bold; font-family: arial;">Invoice Number : </b> ' . $ordmaster['invoice_number'] . '</h2>
        <h2 style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px; padding-bottom: 40px;"><b style="font-weight: bold; font-family: arial;">Invoice Date:</b> ' . getDateFormat($ordmaster['order_received_date'], 3) . '</td>
    </tr>
    
          <tr style="background: #ddd">
            <td style="border:1px solid #222; font-weight: bold; font-family: arial; font-size: 14px; padding: 10px;">SI.No</td>
            <td style="border:1px solid #222; font-weight: bold; font-family: arial; font-size: 14px; padding: 10px;">Description</td>
            <td style="border:1px solid #222; font-weight: bold; font-family: arial; font-size: 14px; padding: 10px;">Total Amount</td>
          </tr>';

  $i = 1;
  $subtotal = '';
  $total = '';
  $toatlTax = "";

  if (is_array($orddetail) && !empty($orddetail)) {

    foreach ($orddetail as $val) {
      $img = '';
      $subtotal = ( $val['quantity'] * $val['product_price']);
      $total += $subtotal;
      $img = get_db_field_value("wps_products_media", "media", "WHERE products_id = '" . $val['products_id'] . "' ORDER BY id ASC LIMIT 0,1");
     
      $img0 = get_image('products', $val['product_image_name'], '100', '100', 'R');
      $imgArr = explode('/', $img0);
      $imgArr = array_reverse($imgArr);
      //trace($imgArr);
      $imgfilename = $imgArr[0];
      $img = IMG_CACH_DIR . '/' . $imgfilename;
      //exit;
      $var .= '<tr>

                <td style="border:1px solid #222; font-family: arial; font-size: 11px; padding: 5px;">' . $i . '</td>
                <td  style="border:1px solid #222; font-family: arial; font-size: 11px; padding: 5px;">
                  <p><img src="' . $img . '"/></p>';
      $var .='<div>';
      $var.= str_replace("'", "", $val['product_name']);
      $var.='<br /><strong>#' . str_replace("'", "", $val['product_code']) . '</strong>';
      
      
      $var .='</td>
                 <td style="border:1px solid #222; font-family: arial; font-size: 11px; padding: 5px;">' . display_price($subtotal) . '</td>
              </tr>';

      $i++;
    }
  }
  $var.='<tr>
            <td colspan="2" style="padding: 10px; text-align: left; font-weight: bold; font-family: arial;">Shipping Amount :</td>
            <td style="background: #ddd; font-weight: bold; font-family: arial; padding: 10px; font-size: 14px;">' . display_price($ordmaster['shipping_amount']) . '</td>
          </tr>';
  if ($ordmaster['coupon_discount_amount'] > 0) {
    $var.='<td colspan="2" style="padding: 10px; text-align: left; font-weight: bold; font-family: arial;">Coupon Discount :</td>
              <td style="background: #ddd; font-weight: bold; font-family: arial; padding: 10px; font-size: 14px;">' . display_price($ordmaster['coupon_discount_amount']) . '</td>
            </tr>';
  }
  $var.='<tr>
            <td colspan="2" style="padding: 10px; text-align: left; font-weight: bold; font-family: arial;">Total :</td>
            <td style="background: #ddd; font-weight: bold; font-family: arial; padding: 10px; font-size: 14px;">' . display_price($grandTotal) . '</td>
          </tr>

          <tr style="text-align: left; padding: 10px;">

            <td colspan="3"><h1 style="font-size: 18px; font-family: arial; margin: 0px; font-weight:bold; text-align: left;padding: 5px 0px; padding-left: 10px;">Amount in Words:</h1>

              <h2 style="font-size: 18px; margin: 0px; font-family: arial;  font-weight:bold; text-align: left; padding: 5px 0px; padding-left: 10px;">' . $wordsAmount . '</h2>  </td>

          </tr>

          <tr>

            <td colspan="3" style="padding-right: 10px;">

              <p style="font-size: 16px; font-family: arial; font-weight: bold; text-align: right; margin: 0px; padding: 5px 0px;">For Shelley Enterprises:</p>

              <div style="width: 300px; background: #ddd; height: 60px; float: right;"></div>

              <div style="clear: both;">

                <p style="font-size: 16px; font-family: arial; font-weight: bold; text-align: right; margin: 0px; padding: 5px 0px;">Authorized Signatory</p>

            </td>

          </tr>       
      
  </table>';

  return $var;
}



function invoice_content_mail($ordmaster, $orddetail) {

  $ci = CI();
  $ci->load->helper('words');
  $curr_symbol = display_symbol();
  $grandTotal = $ordmaster['total_amount'];
  $wordsAmount = getStringOfAmount(number_format($grandTotal, 2));
  $wordsAmount .= ' Only';
  $var = '';

  $var .= '<table width="1024" border="0" cellpadding="0" cellspacing="0" style="padding:10px;">
    <tr>
      <td colspan="2" style="text-align: center;">
        <h1 style="text-align: center; font-size: 24px; padding-bottom: 30px; font-family: arial; font-weight: bold;">Tax Invoice/Bill Of Supply/Cash Memo</h1>
      </td>
    </tr>
    <tr>
      <td style="padding-bottom: 30px;"><img src="' . theme_url() . 'images/logo.png" class="img_responsive" width="120"></td>
      <td style="text-align: right;">
        <h1 style="margin: 0px; font-family: arial; padding: 5px 0px; width: 100%; text-align: right; font-weight:bold; font-size: 20px;">Ship To,</h1>
        <h2 style="margin: 0px; font-family: arial;  padding: 5px 0px; width: 100%; text-align: right; font-weight:bold; font-size: 16px;"> Billing Address:</h2>

        <h6 style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;">' . $ordmaster['billing_name'] . '</h6>
        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;">' . $ordmaster['billing_address'] . ', ' . $ordmaster['billing_city'] . '</p>
        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;">' . $ordmaster['billing_state'] . ' - ' . $ordmaster['billing_country'] . '</p> 
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <h1 style="margin: 0px; font-family: arial; padding: 5px 0px; width: 100%; text-align: left; font-weight:bold; font-size: 20px;">Sold By:</h1>
        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;">Weblieu</p>
        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;">Rainbow House H Flat, 1st floor, Next to Metro Station, South Patel Nagar Market, New Delhi</p>
        <p style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px; padding-bottom: 40px;">Contact: +91-9999971701</p>
      </td>
    </tr>

    <tr>
      <td style="text-align: left;">
        <h1 style="font-size: 16px; font-weight:normal;"><b style="font-weight: bold; margin: 0px; padding: 0px; font-family: arial;">Order Date: </b> ' . getDateFormat($ordmaster['order_received_date'], 3) . '</h1>
      <td style="text-align: right;">
        <h2 style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px;"><b style="font-weight: bold; font-family: arial;">Invoice Number : </b> ' . $ordmaster['invoice_number'] . '</h2>
        <h2 style="margin: 0px; font-family: arial; font-size: 16px; font-weight: normal; padding: 5px 0px; padding-bottom: 40px;"><b style="font-weight: bold; font-family: arial;">Invoice Date:</b> ' . getDateFormat($ordmaster['order_received_date'], 3) . '</td>
    </tr>
    <tr>
      <td colspan="2">
        <table width="100%" border="1" cellspacing="0" cellpadding="0" style="margin: 0px; text-align: center;">
          <tr style="background: #ddd">
            <td style="border:1px solid #222; font-weight: bold; font-family: arial; font-size: 14px; padding: 10px;">SI.No</td>
            <td style="border:1px solid #222; font-weight: bold; font-family: arial; font-size: 14px; padding: 10px;">Description</td>
            <td style="border:1px solid #222; font-weight: bold; font-family: arial; font-size: 14px; padding: 10px;">Unit Price </td>
            <td style="border:1px solid #222; font-weight: bold; font-family: arial; font-size: 14px; padding: 10px;">Quantity</td>
            <td style="border:1px solid #222; font-weight: bold; font-family: arial; font-size: 14px; padding: 10px;">Net Amount</td>

            <td style="border:1px solid #222; font-weight: bold; font-family: arial; font-size: 14px; padding: 10px;">Total Amount</td>

          </tr>';


  $i = 1;
  $subtotal = '';
  $total = '';
  $toatlTax = "";
  if (is_array($orddetail) && !empty($orddetail)) {
    foreach ($orddetail as $val) {
      print_r($val);
      $img = '';
      $toatlTax += $ordmaster['vat_amount'];
      $subtotal = ( $val['quantity'] * $val['product_price']);
      $total += $subtotal;
      $img = get_db_field_value("wps_products_media", "media", "WHERE products_id = '" . $val['products_id'] . "' ORDER BY id ASC LIMIT 0,1");


      $var .='<tr>

                <td>' . $i . '</td>

                <td style="padding: 10px; font-family: arial; font-size: 14px;">
                  <img style="float: left"; src="' . get_image('products', $img, '75', '75', 'R') . '"/>' . $val['product_name'] . '<div>';
      $var .='<span class="">
                      <strong>Size</strong>: <span class="">' . $val['size'] . '</span>';
      $var .='</span>
                  </div>

                </td>

                <td style="padding: 10px; font-size: 14px; font-family: arial;">' . display_price($val['product_price']) . '</td>

                <td style="padding: 10px; font-size: 14px; font-family: arial;">' . $val['quantity'] . '</td>

                <td style="padding: 10px; font-size: 14px; font-family: arial;">' . display_price($val['product_price'] * $val['quantity']) . '</td>

                <td style="padding: 10px; font-size: 14px; font-family: arial;">' . display_price($subtotal) . '</td>

              </tr>';
      $i++;
    }
  }
  $var .='<tr>

            <td colspan="5" style="padding: 10px; text-align: left; font-weight: bold; font-family: arial;">Total :</td>

            <td style="background: #ddd; font-weight: bold; font-family: arial; padding: 10px; font-size: 14px;">' . display_price($grandTotal) . '</td>

          </tr>

          <tr style="text-align: left; padding: 10px;">

            <td colspan="6"><h1 style="font-size: 18px; font-family: arial; margin: 0px; font-weight:bold; text-align: left;padding: 5px 0px; padding-left: 10px;">Amount in Words:</h1>

              <h2 style="font-size: 18px; margin: 0px; font-family: arial;  font-weight:bold; text-align: left; padding: 5px 0px; padding-left: 10px;">' . $wordsAmount . '</h2>  </td>

          </tr>

          <tr>

            <td colspan="9" style="padding-right: 10px;">

              <p style="font-size: 16px; font-family: arial; font-weight: bold; text-align: right; margin: 0px; padding: 5px 0px;">For Weblieu:</p>

              <div style="width: 300px; background: #ddd; height: 60px; float: right;"></div>

              <div style="clear: both;">

                <p style="font-size: 16px; font-family: arial; font-weight: bold; text-align: right; margin: 0px; padding: 5px 0px;">Authorized Signatory</p>

            </td>

          </tr>

        </table>

      </td>

    </tr>
  </table>';

  return $var;
}

if (!function_exists('addToCart')) {

  function addToCart($parent = '0', $condtion = "AND status='1'", $fields = 'SQL_CALC_FOUND_ROWS*') {
    $parent = (int) $parent;
    $ci = CI();
    $output = array();
    $sql = "SELECT category_id as subcatId, category_name as name, category_image as image FROM wps_categories WHERE parent_id=$parent $condtion  ";
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {
      foreach ($query->result_array() as $row) {
        $output[] = $row;
      }
    }
    return $output;
  }

}

if (!function_exists('isProductAvailable')) {

  function isProductAvailable($productId, $qty, $size, $color, $condition = "AND status='1'") {
    $ci = CI();
    $output = array();
    $sql = "SELECT * FROM wps_products WHERE products_id=$productId $condition  ";
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {
      foreach ($query->result_array() as $row) {
        $size_arr = explode(',', $row['size_ids']);
        $color_arr = explode(',', $row['color_ids']);
        if ($row['product_qty'] >= $qty && in_array($size, $size_arr) && in_array($color, $color_arr)) {
          $output[] = $row;
        } else {
          $output = false;
        }
      }
    }
    return $output;
  }

}

if (!function_exists('isProductAttributeAvailable')) {

  function isProductAttributeAvailable($productId, $qty, $size, $color, $condition = "AND status='1'") {
    $ci = CI();
    $output = array();
    $sql = "SELECT * FROM wps_product_attributes WHERE product_id=$productId AND color_id=$color AND size_id=$size $condition  ";
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {
      foreach ($query->result_array() as $row) {
        // echo $row['quantity']; die;
        if ($row['quantity'] >= $qty) {
          $output[] = $row;
        } else {
          $output = false;
        }
      }
    } else {
      $output = false;
    }
    return $output;
  }

}

if (!function_exists('isProductAdded')) {

  function isProductAdded($productId, $userId, $sizeId, $colorId, $sizeType, $customSize) {
    $ci = CI();
    $output = false;
    if ($sizeType == 'default') {
      $sql = "SELECT * FROM wps_cart WHERE product_id=$productId AND user_id = $userId AND size_id = $sizeId AND color_id = $colorId AND status=1";
    } else {
      $sql = "SELECT * FROM wps_cart WHERE product_id=$productId AND user_id = $userId AND custom_size = '$customSize' AND color_id = $colorId AND status=1";
    }
    // echo $sql; die;
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {
      $output = true;
    }
    return $output;
  }

}

if (!function_exists('isProductAddedToWishlist')) {

  function isProductAddedToWishlist($productId, $userId) {
    $ci = CI();
    $output = false;
    $sql = "SELECT * FROM wps_wishlists WHERE products_id=$productId AND customer_id = $userId";
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {
      $output = true;
    }
    return $output;
  }

}