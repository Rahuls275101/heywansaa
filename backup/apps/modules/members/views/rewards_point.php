<?php
$this->load->view("top");
$fieldType = $this->session->userdata('field_type');
  
$user_id=$this->session->userdata();
if(!isset($user_id))
{
  redirect('login');
}

?>


<style>
    .earnedcoins span i, .pendingcoins span i {
    font-size: 3.3rem;
    color: #ff6a00;
}
.earnedcoins, .pendingcoins {
    background-color: #f1f1f1;
    padding: 1rem 1.5rem;
    border-radius: 3px;
    text-align: center;
    box-shadow: 2px 2px 3px 1px;
}
</style>
<main class="main">
            <!-- Start of Page Header -->
            <!--<div class="page-header">-->
            <!--    <div class="container">-->
            <!--        <h1 class="page-title mb-0">Reward Coin</h1>-->
            <!--    </div>-->
            <!--</div>-->
            <!-- End of Page Header -->
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb">
                        <h1 class="page-title mb-0">Reward Coin</h1>
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li>Reward Coin</li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->
            <div class="container">
              <div class="row">
                <div class="col-md-3">
                   <?php $this->load->view('members/left'); ?>
                </div>

                <div class="col-md-9">
                  <div class="tab-pane mb-4" id="account-orders">
                    <div class="rewardpointsbxrow" style="float:right">
                                        <div class="rewardpointsbxcol">
                                            <div class="earnedcoins">
                                              <span id="total_coin"> <i class="fas fa-coins fa-2x"></i> 0</span>
                                                <p>Wallet Coin</p>
                                            </div>
                                        </div>
                                    </div>
                    <table id="table-breakpoint" class="shop-table account-orders-table mb-6 table-stripped">
    <thead>
        <tr>
           
            <th class="order-date">Date</th>
             <th class="order-id">Order</th>
            <th class="order-total">Product Name</th>
            <th class="order-actions">Total Price</th>
            <th class="order-actions">Earn Coin</th>
        </tr>
    </thead>
    <tbody>

      <?php
      $total_coin=0;
      $ttl_cr=0;
      $ttl_dr=0;
      if(is_array($order_reward_data) && !empty($order_reward_data))
      {
        foreach($order_reward_data as $ord=>$o)
        {
          if($o['cr_dr']=='cr')
          {
              $ttl_cr=$ttl_cr+$o['earn_coin'];
          }
          else
          {
              $ttl_dr=$ttl_dr+$o['earn_coin'];
          }
          
          
          
            $total_coin=$ttl_cr-$ttl_dr;
            
             if($o['cr_dr']=='cr')
          {  
            
            
        ?>
          <tr>
              <td class="order-date"><?php echo date('d M,Y',strtotime($o['created_at'])); ?></td>
              <td class="order-id"><?php echo $o['invoice_number']; ?></td>
              
              <td class="order-status"><img src="<?php echo get_image('products', $o['product_image_name'], 270, 270, 'AR');  ?>"><?php echo $o['product_name']; ?></td>
              <td class="order-total">
                  <span class="order-price">₹  <?php
                //   echo $o['gst'] + $o['product_price']; 
                   echo $o['product_price']; 
                  ?></span>
              </td>
              <td class="order-total">
                  <span class="order-price"><?php echo $o['earn_coin']; ?></span>
              </td>
          </tr>
        <?php } } 
      } else{echo "No data Found!";} ?>
    </tbody>
                    </table>
                    <a href="<?php echo base_url(); ?>" class="btn btn-dark btn-rounded btn-icon-right">Go
                        Shop<i class="w-icon-long-arrow-right"></i></a>
                  </div>
                </div>
              </div>
            </div>


</main>


 <script src="https://kerrys.co.in/demo/heywansa/assets/designer/themes/default/assets/vendor/jquery/jquery.min.js"></script>

<script>
    $('#total_coin').html('<i class="fas fa-coins"></i> <?php echo $total_coin; ?>');
</script>


<?php $this->load->view("bottom"); ?>