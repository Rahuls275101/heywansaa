<?php 

use App\Models\Commanmodel;
 $commanmodel = new Commanmodel();
   $addressView = $commanmodel->get_single_query('address',array('id' => 1)); 
    $request = service('request');
    
    
?>


  <main class="main">
            <div class="page-header">
                <div class="container d-flex flex-column align-items-center">
                    <nav aria-label="breadcrumb" class="breadcrumb-nav">
                        <div class="container">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(''); ?>">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Wishlist
                                </li>
                            </ol>
                        </div>
                    </nav>

                    <h1>Wishlist</h1>
                </div>
            </div>

            <div class="container">
                <div class="wishlist-title">
                    <h2 class="p-2">My wishlist </h2>
                </div>
                <div class="wishlist-table-container">
                    <table class="table table-wishlist mb-0">
                        <thead>
                            <tr>
                                <th class="thumbnail-col"></th>
                                <th class="product-col">Product</th>
                                <th class="price-col">Price</th>
                                <th class="status-col">Stock Status</th>
                                <th class="action-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($wishlist as $wishlistrow) { 
                              $productName = $commanmodel->get_single_query('product', ['product_id' => $wishlistrow->wishlist_product_id]);
                            ?>
                            <tr class="product-row">
                                <td>
                                    <figure class="product-image-container">
                                        <a href="<?php echo base_url('product'); ?>/<?php echo $productName->slug; ?>" class="product-image">
                                            <img src="<?php echo base_url('assets/images/'); ?>/<?php echo $productName->product_thumbnail; ?>" style="width: 71px;" alt="product">
                                        </a>

                                        <a href="#" class="btn-remove icon-cancel" title="Remove Product"></a>
                                    </figure>
                                </td>
                                <td>
                                    <h5 class="product-title">
                                        <a href="product.html"><?php echo $productName->product_name; ?></a>
                                    </h5>
                                </td>
                                <td class="price-box"><?php echo $productName->product_price; ?></td>
                                <td>
                                    <span class="stock-status"><?php echo ($productName->quantity>0)?' In stock':' Out of stock'; ?></span>
                                </td>
                                <td class="action">
                                    <a href="<?php echo base_url('product'); ?>/<?php echo $productName->slug; ?>" class="btn btn-quickview mt-1 mt-md-0"
                                        title=" View">
                                        View</a>
                                   
                                </td>
                            </tr>
                        <?php } ?>
                           

                           
                        </tbody>
                    </table>
                </div><!-- End .cart-table-container -->
            </div><!-- End .container -->
        </main><!-- End .main -->