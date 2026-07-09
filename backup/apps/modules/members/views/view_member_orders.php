<?php
$this->load->view("top");
$fieldType = $this->session->userdata('field_type');
  
$user_id=$this->session->userdata();
if(!isset($user_id))
{
  redirect('login');
}

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>



<style>
    /* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 15% auto; /* 15% from the top and centered */
  padding: 20px;
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
</style>






















<main class="main">
            <!-- Start of Page Header -->
            <!--<div class="page-header">-->
            <!--    <div class="container">-->
            <!--        <h1 class="page-title mb-0">My Order</h1>-->
            <!--    </div>-->
            <!--</div>-->
            <!-- End of Page Header -->
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb">
                        <h1 class="page-title mb-0">My Order</h1>
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li>My Order</li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->
            <div class="page-content">
            <div class="container">
              <div class="row">
                <div class="col-md-3">
                   <?php $this->load->view('members/left'); ?>
                </div>

                <div class="col-md-9">
                  <div class="tab-pane mb-4" id="account-orders">
                    <div class="icon-box icon-box-side icon-box-light" style="justify-content: left;">
                        <span class="icon-box-icon icon-orders">
                            <i class="w-icon-orders"></i>
                        </span>
                        <div class="icon-box-content">
                            <h4 class="icon-box-title text-capitalize ls-normal mb-0">Orders</h4>
                            <?php
                                if($this->session->flashdata('cancel_msg'))
                                {
                                    echo $this->session->flashdata('cancel_msg')."This is the msg";
                                }
                            ?>
                        </div>
                    </div>
                    <table width="100%" id="table-breakpoint" class="shop-table account-orders-table mb-6 table-stripped">
    <thead>
        <tr>
          
            <th class="order-id">Order</th>
            <th class="order-date">Date</th>
            <th class="order-status">Status</th>
            <th class="order-total">Payment Status</th>
            <th class="order-total">Total</th>
            <th class="order-actions">Actions</th>
        </tr>
    </thead>
    <tbody>

      <?php 
      if(is_array($orders) && !empty($orders))
      {
          $c=0;
          $odid=0;
          $i=0;
        foreach($orders as $ord=>$o)
        {
            $odid=$o['order_id'];
            // $orderdetails=$this->db->query("select wps_orders_products.product_name,wps_orders_products.orders_products_id,wps_orders_products.order_id,
            // wps_orders_products.product_image,wps_orders_products.product_image_name,wps_orders_products.product_price,
            // wps_orders_products.quantity, wps_products.vendor_id , wps_order.customers_id,wps_order.payment_status
            // from wps_orders_products inner join wps_products on wps_products.products_id=wps_orders_products.products_id
            // inner join wps_order on wps_order.order_id=wps_orders_products.order_id where wps_orders_products.order_id='$odid'
            // and wps_order.customers_id='$user_id'  group by wps_orders_products.orders_products_id")->result_array();
                                                 
             $this->session->set_userdata('orderdetailuserdataorderid',$o['order_id']);
        ?>
          <tr>
           
              <td class="order-id"><?php echo $o['invoice_number']; ?></td>
              <td class="order-date"><?php echo date('d M,Y',strtotime($o['order_received_date'])); ?></td>
              <td class="order-status">
                <?php
                 $order_status= $o['order_status']; 
                  if($order_status=='0')
                               {
                                   echo "<br><button class='btn btn-info'>Order Place</button>";
                               }
                               elseif($order_status=='1')
                               {
                                   echo "<br><button class='btn btn-info'>Order Confirmed</button>";
                               }
                               elseif($order_status=='2')
                               {
                                   echo "<br><button class='btn btn-info'>Dispatched</button>";
                               }
                               elseif($order_status=='3')
                               {
                                   echo "<br><button class='btn btn-info'>InTransit</button>";
                               }
                               elseif($order_status=='4')
                               {
                                   echo "<br><button class='btn btn-info'>Out for delivery</button>";
                               }
                               elseif($order_status=='5')
                               {
                                   echo "<br><button class='btn btn-info'>Cancelled</button>";
                               }
                               elseif($order_status=='6')
                               {
                                   echo "<br><button class='btn btn-info'>Returned</button>";
                               }
                               elseif($order_status=='7')
                               {
                                   echo "<br><button class='btn btn-info'>Request for Return</button>";
                               }
                               elseif($order_status=='8')
                               {
                                   echo "<br><button class='btn btn-info'>Delivered</button>";
                               }
                               elseif($order_status=='9')
                               {
                                   echo "<br><button class='btn btn-info'>Deleted</button>";
                               }

               ?>               </td>
              <td class="order-total"><span class="order-status">
                <?php
				echo "<br><button class='btn btn-info'>".$o['payment_status']."</button>";
				/*
                 $payment_status= $o['payment_status']; 
                  if($payment_status=='Paid')
                               {
                                   echo "<br><button class='btn btn-info'>Paid</button>";
                               }
                               else if($payment_status=='Unpaid')
                               {
                                   echo "<br><button class='btn btn-info'>Unpaid</button>";
                               }
                               else if($payment_status=='Pending')
                               {
                                   echo "<br><button class='btn btn-info'>Pending</button>";
                               }
                                
*/
               ?>
              </span></td>
              <td class="order-total">
                  <span class="order-price">₹<?php echo $o['total_amount'] ?></span> for
                  <span class="order-quantity">
                  
                   <?php 
                   $order_id=$o['order_id'];
                   $count= $this->db->query("select count(order_id)as count from wps_orders_products where order_id='$order_id'")->result_array();
                   echo $count[0]['count']; ?>
                 </span> item              </td>
              <td class="order-action">
                  <div class="form-group">
                    <!--<a href="<?php echo base_url().'mark-my-product-cancel/'.$o['order_id']; ?>"class="btn btn-outline btn-default btn-block btn-sm btn-rounded">Cancel Order</a>-->
                    <br>
                  </div>
                  <?php
                //   echo $o['cancelation_expiry_days'];
                  if($order_status=='8'){?>
                  <!--<a href="" class="btn btn-dark  text-white">Cancel This Order</a>-->
                 <?php } ?>
                 
                 <button id="myBtn<?php echo $o['order_id']; ?>" data-orderId="<?php echo $o['order_id']; ?>" 
                 data-userid="<?php echo $this->session->userdata('user_id'); ?>" 
                 class="btn btn-outline btn-default btn-block btn-sm btn-rounded">View</button>
                    
                    <script>
                        $('#myBtn<?php echo $o['order_id']; ?>').on('click',function(){
                           ;
                            var orderid= $(this).data('orderid');
                            var userid= $(this).data('userid');
                            
                            
                            $.ajax({
                              url:site_url+'members/getorderdetailslistbyorderid',
                              method:"post",
                              data:{orderid:orderid,userid:userid},
                              success(html)
                              {
                                    $('#orderdetailstable').html(html);
                                    $('#myModal').show();
                              }
                            })
                        })
                    </script>              </td>
          </tr>
        <?php } 
      } else{echo "No data Found!";} ?>
    </tbody>
                    </table>
                    <a href="<?php echo base_url(); ?>" class="btn btn-dark btn-rounded btn-icon-right">Go
                        Shop<i class="w-icon-long-arrow-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
        </div>
</main>



      
                    <div id="myModal" class="modal">
                      <div class="modal-content" >
                        <span class="close" onclick="$('#myModal').hide()">&times;</span>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Order Details </h4>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="shop-table account-orders-table mb-6 table-stripped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">Product Name</th>
                                                    <th class="text-center">Sub Order ID</th>
                                                     <th class="text-center">Tracking Number (AWB.NO)</th>
                                                    <th class="text-center">Price</th>
                                                    <th class="text-center">Quantity</th>
                                                    <th class="text-center">Total Price</th>
                                                </tr>
                                            </thead>
                                            <tbody  id="orderdetailstable">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                    
                    </div>



            <!--below modal is for product cancelation-->
                    <div id="productcancelation" class="modal">
                      <div class="modal-content" >
                        <span class="close" onclick="$('#productcancelation').hide()">&times;</span>
                        <div class="container">
                            <div class="row">
                               
                                <div class="col-md-12">
                                   <h3>Please select reason for cancel product</h3>
                                   <form>
                                        <label>Reason </label>
                                       <ul class="list-style-none">
                                           <li><input type="radio" onclick="$('#reason').val($(this).val())" class="ml-2 mr-2 pd-2" name="reason1" required value="Your order will be exchanged for a new identical product of a different size or color">   Your order will be exchanged for a new identical product of a different size or color</li>
                                           <li><input type="radio" onclick="$('#reason').val($(this).val())" class="ml-2 mr-2 pd-2" name="reason1" required value="Replace: The product in your order will be replaced with an identical product  work).">   Replace: The product in your order will be replaced that causes it not to work).</li>
                                           <li><input type="radio" onclick="$('#reason').val($(this).val())" class="ml-2 mr-2 pd-2" name="reason1" required value="Refund: If the product of your choice ">   Refund: If the product of your choice is unavailable in your preferred size or enario, you may choose Refund to have your money returned to you </li>
                                           <li><input type="radio" onclick="$('#reason').val($(this).val())" class="ml-2 mr-2 pd-2" name="reason1" required value="Depending on the kind of product you wish to return, your">Depending on the kind of product you wish to return, your return request may have to undergo a verification process</li>
                                           <li><input type="radio" onclick="$('#reason').val($(this).val())" class="ml-2 mr-2 pd-2" name="reason1" required value="Following verification, you will be required to confirm  ordered.">Following verification, you will be required to confirm your decision based on the category of product ordered.</li>
                                           <li><input type="radio" onclick="$('#reason').val($(this).val())" class="ml-2 mr-2 pd-2" name="reason1" required value="Keep ready all the requisite items  freebies, accessories, etc.">Keep ready all the requisite items necessary for a smooth returns process — accessories, etc.</li>
                                           <li><input type="radio" onclick="$('#reason').val($(this).val())" class="ml-2 mr-2 pd-2" name="reason1" required value="Pickup and Delivery of your order will be">Pickup and Delivery of your order will be scheduled and details will be communicated in case of exchanges and replacements</li>
                                           <li><input type="radio" onclick="$('#reason').val($(this).val())" class="ml-2 mr-2 pd-2" name="reason1" required value="Refund will be initiated and processed if applicable">Refund will be initiated and processed if applicable</li>
                                           <li><input type="radio" onclick="$('#reason').val($(this).val())" class="ml-2 mr-2 pd-2" name="reason1" required value="Your request will be fulfilled according ">Your request will be fulfilled according to heywansaa returns/replacement guarante</li>
                                       </ul>
                                       <div class="form-group">
                                            <label>Remark</label>
                                            <input type="hidden" id="prod_id" value="" required>
                                            <input type="hidden" id="reason" name="reason" value="" required>
                                            <textarea class="form-control" id="remark" placeholder="Description" required></textarea>
                                        </div>
                                         <div class="form-group pt-2 text-right">
                                             <button type="button" class="btn btn-info" id="cancelsignleproduct" >Cancel Now</button>
                                         </div>
                                   </form>
                                </div>
                            </div>
                        </div>
                      </div>
                    
                    </div>

<script>
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("myBtn");
    var span = document.getElementsByClassName("close");
    

    
    
    btn.onclick=function() 
    {
      modal.style.display = "block";
    }
    span.onclick = function() 
    {
      modal.style.display = "none";
    }
    window.onclick = function(event) 
    {
      if (event.target == modal) 
      {
        modal.style.display = "none";
      }
    }
</script>
<script>
    $('#cancelsignleproduct').on('click',function(){
        
var products_id     =   $('#prod_id').val();
var reason          =   $('#reason').val();
var remark          =   $('#remark').val();
        
        
        $.ajax({
            url:BASEURL+'members/cancelsingleproduct',
            method:"POST",
            data:{products_id:products_id,reason:reason,remark:remark},
            success:function(res)
            {
                var d=JSON.parse(res);
               if(d.data=='success')
               {
                   window.location.reload();
               }
                
            }
        })
    })
</script>

<?php $this->load->view("bottom"); ?>