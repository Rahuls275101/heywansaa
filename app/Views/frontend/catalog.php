<?php 

use App\Models\Commanmodel;
 $commanmodel = new Commanmodel();
 
    $request = service('request');
    
     $category = $commanmodel->all_multiple_query_order_by('category',array('parent_id' => 0),'category_id','ASC');
?>

  <main class="main">
            <div class="container">
                <!-- <nav aria-label="breadcrumb" class="breadcrumb-nav">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#">Men</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Accessories</li>
                    </ol>
                </nav> -->

                <div class="row">
                    <div class="col-lg-9 main-content satya">
                        <nav class="toolbox  sticky-header" data-sticky-options="{'mobile': true}">
                            <div class="toolbox-left ml-3">
                                <a href="#" class="sidebar-toggle"><svg data-name="Layer 3" id="Layer_3"
                                        viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                        <line x1="15" x2="26" y1="9" y2="9" class="cls-1"></line>
                                        <line x1="6" x2="9" y1="9" y2="9" class="cls-1"></line>
                                        <line x1="23" x2="26" y1="16" y2="16" class="cls-1"></line>
                                        <line x1="6" x2="17" y1="16" y2="16" class="cls-1"></line>
                                        <line x1="17" x2="26" y1="23" y2="23" class="cls-1"></line>
                                        <line x1="6" x2="11" y1="23" y2="23" class="cls-1"></line>
                                        <path
                                            d="M14.5,8.92A2.6,2.6,0,0,1,12,11.5,2.6,2.6,0,0,1,9.5,8.92a2.5,2.5,0,0,1,5,0Z"
                                            class="cls-2"></path>
                                        <path d="M22.5,15.92a2.5,2.5,0,1,1-5,0,2.5,2.5,0,0,1,5,0Z" class="cls-2"></path>
                                        <path d="M21,16a1,1,0,1,1-2,0,1,1,0,0,1,2,0Z" class="cls-3"></path>
                                        <path
                                            d="M16.5,22.92A2.6,2.6,0,0,1,14,25.5a2.6,2.6,0,0,1-2.5-2.58,2.5,2.5,0,0,1,5,0Z"
                                            class="cls-2"></path>
                                    </svg>
                                    <span>Filter</span>
                                </a>

                            <div class="toolbox-left">
                                <a href="#" class="sidebar-toggle">
                                    <svg data-name="Layer 3" id="Layer_3" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                        <line x1="15" x2="26" y1="9" y2="9" class="cls-1"></line>
                                        <line x1="6" x2="9" y1="9" y2="9" class="cls-1"></line>
                                        <line x1="23" x2="26" y1="16" y2="16" class="cls-1"></line>
                                        <line x1="6" x2="17" y1="16" y2="16" class="cls-1"></line>
                                        <line x1="17" x2="26" y1="23" y2="23" class="cls-1"></line>
                                        <line x1="6" x2="11" y1="23" y2="23" class="cls-1"></line>
                                        <path d="M14.5,8.92A2.6,2.6,0,0,1,12,11.5,2.6,2.6,0,0,1,9.5,8.92a2.5,2.5,0,0,1,5,0Z" class="cls-2"></path>
                                        <path d="M22.5,15.92a2.5,2.5,0,1,1-5,0,2.5,2.5,0,0,1,5,0Z" class="cls-2"></path>
                                        <path d="M21,16a1,1,0,1,1-2,0,1,1,0,0,1,2,0Z" class="cls-3"></path>
                                        <path d="M16.5,22.92A2.6,2.6,0,0,1,14,25.5a2.6,2.6,0,0,1-2.5-2.58,2.5,2.5,0,0,1,5,0Z" class="cls-2"></path>
                                    </svg>
                                    <span>Filter</span>
                                </a>
                            
                                <div class="toolbox-item toolbox-sort">
                                    <label>Sort By:</label>
                            
                                    <div class="select-custom">
                                        <select id="orderby" class="form-control common_selector_change">
                            											<option value="menu_order" selected="selected">Default sorting</option>
                            										
                            											<option value="newness">Sort by newness</option>
                            											<option value="pricelow">Sort by Price low to high</option>
                            											<option value="pricehigh">Sort by Price high to low</option>
                            										
                            										</select>
                                    </div>
                                    <!-- End .select-custom -->
                            
                            
                                </div>
                                <!-- End .toolbox-item -->
                            </div>
                                <!-- End .toolbox-item -->
                            </div>
                            <!-- End .toolbox-left -->

                            <div class="toolbox-right">
                             
                                <!-- End .layout-modes -->
                            </div>
                            <!-- End .toolbox-right -->
                        </nav>

                    <div class="row m-b-2 ajax_list">
                       
                    
                    </div>


                  
                        <!-- End .row -->

                        <nav class="toolbox toolbox-pagination mt-1">

                            <!-- End .toolbox-item -->

                            <ul class="pagination toolbox-item " id="pagination_link">
                                <li class="page-item disabled">
                                    <a class="page-link page-link-btn" href="#"><i class="icon-angle-left"></i></a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><span class="page-link">...</span></li>
                                <li class="page-item">
                                    <a class="page-link page-link-btn" href="#"><i class="icon-angle-right"></i></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!-- End .col-lg-9 -->

                    <div class="sidebar-overlay"></div> 
                    <aside class="sidebar-shop col-lg-3 order-lg-first mobile-sidebar">
                        <div class="sidebar-wrapper">
                            <div class="widget">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-body-2" role="button" aria-expanded="true"
                                        aria-controls="widget-body-2">Categories</a>
                                </h3>

                                <div class="collapse show" id="widget-body-2">
                                    <div class="widget-body">
                                        <ul class="cat-list">
                                            <li><a href="<?php echo base_url('catalog/all'); ?>">All Categories</a></li>
                                            <?php foreach($category as $categoryrow) { ?>
                                            <li><a href="<?php echo base_url('catalog/'); ?>/<?php echo $categoryrow->url_slug; ?>"><?php echo $categoryrow->category_name; ?></a></li>
                                            <?php } ?>
                                         
                                        </ul>
                                    </div>
                                    <!-- End .widget-body -->
                                </div>
                                <!-- End .collapse -->
                            </div>
                          
                            <!-- End .widget -->
                        </div>
                        <!-- End .sidebar-wrapper -->
                    </aside>
                    <!-- End .col-lg-3 -->
                </div>
                <!-- End .row -->
            </div>
            <!-- End .container -->

            <div class="mb-4"></div>
            <!-- margin -->
        </main>
        <!-- End .main -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>




<script>
$(document).ready(function() {
    // Initialize the slider
  /*  $(".slider-range").slider({
        range: true,
        min: 500,
        max: 500000,
        values: [500, 100000],
        slide: function(event, ui) {
            $(".amount").val("Rs" + ui.values[0] + " - Rs" + ui.values[1]);
            $('#minprice').val(ui.values[0]);
            $('#maxprice').val(ui.values[1]);
            ajax_list(1);
        }
    });

    // Set initial amount value
    $(".amount").val("Rs" + $(".slider-range").slider("values", 0) +
        " - Rs" + $(".slider-range").slider("values", 1));
    
    // Set initial minprice and maxprice values
    $('#minprice').val($(".slider-range").slider("values", 0));
    $('#maxprice').val($(".slider-range").slider("values", 1));
*/
    // Initial ajax call
    ajax_list(1);

    // Event listeners
    $('.common_selector_change').on('change', function() {
        ajax_list(1);
    });

    $('.common_selector').click(function() {
        ajax_list(1);
    });
    
    

    // Function to fetch and filter data
    function ajax_list(page) {
        var action = 'fetch_data';
        var id = '<?php echo $id; ?>';
        var search = $('#search').val();
        var list = '<?php echo $url; ?>';
        var collection = '<?php echo $collection; ?>';
         var minprice = '';
          var maxprice = '';
          var shortby =  $('#orderby').val();
           var catsearch =  $('#catsearch').val();
        
        $.ajax({
            url: "<?php echo base_url('ajax_list'); ?>/" + page,
            method: "POST",
            dataType: "JSON",
            data: {action: action, id: id, list: list, search: search, collection: collection,minprice:minprice,maxprice:maxprice,shortby:shortby,catsearch:catsearch},
            beforeSend: function() {
                // Add loading animation or something if needed
            },
            success: function(data) {
                $('#item_total').html(data.item_total);
                $('.ajax_list').html(data.product_list);
                $('#pagination_link').html(data.pagination_link);
            }
        });
    }

    // Function to get selected filters
    function get_filter_production(class_name) {
        var filter = [];
        $('.' + class_name + ':checked').each(function() {
            filter.push($(this).val());
        });
        return filter;
    }
});

</script>