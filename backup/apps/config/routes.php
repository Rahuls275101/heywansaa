<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  |	$route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */
$route['default_controller'] = 'home';

//Routes for Admin Folder

$route['wps-admin'] = "admin";
$route['wps-admin/forgot-password'] = "admin/forgotten_password";
$route['wps-admin/dashboard/(:any)'] = "admin/dashboard/$1";

$route['wps-admin/category/(:any)'] = "admin/category/$1";
$route['wps-admin/category/(:any)/(:any)'] = "admin/category/$1/$2";

$route['wps-admin/subadmin/(:any)'] = "admin/subadmin/$1";
$route['wps-admin/subadmin/(:any)/(:any)'] = "admin/subadmin/$1/$2";

$route['wps-admin/enquiry/(:any)'] = "admin/enquiry/$1";
$route['wps-admin/enquiry/(:any)/(:any)'] = "admin/enquiry/$1/$2";

$route['wps-admin/staticpages/(:any)/(:any)'] = "admin/staticpages/$1/$2";

$route['wps-admin/products/(:any)'] = "admin/products/$1";
$route['wps-admin/products/(:any)/(:any)'] = "admin/products/$1/$2";

$route['wps-admin/discountcoupon/(:any)'] = "admin/discountcoupon/$1";
$route['wps-admin/discountcoupon/(:any)/(:any)'] = "admin/discountcoupon/$1/$2";

$route['wps-admin/banners/(:any)'] = "admin/banners/$1";
$route['wps-admin/banners/(:any)/(:any)'] = "admin/banners/$1/$2";

$route['wps-admin/meta/(:any)/(:any)'] = "admin/meta/$1/$2";

$route['wps-admin/location/(:any)'] = "admin/location/$1";
$route['wps-admin/location/(:any)/(:any)'] = "admin/location/$1/$2";

$route['wps-admin/subloccontent/(:any)'] = "admin/subloccontent/$1";
$route['wps-admin/subloccontent/(:any)/(:any)'] = "admin/subloccontent/$1/$2";

$route['wps-admin/subcontent/(:any)'] = "admin/subcontent/$1";
$route['wps-admin/subcontent/(:any)/(:any)'] = "admin/subcontent/$1/$2";

$route['wps-admin/size/(:any)'] = "admin/size/$1";
$route['wps-admin/size/(:any)/(:any)'] = "admin/size/$1/$2";

$route['wps-admin/color/(:any)'] = "admin/color/$1";
$route['wps-admin/color/(:any)/(:any)'] = "admin/color/$1/$2";

$route['wps-admin/orders/(:any)'] = "admin/orders/$1";
$route['wps-admin/orders/(:any)/(:any)'] = "admin/orders/$1/$2";



$route['wps-admin/(:any)'] = "admin/$1";
//End here
// custome by raaz


$route['wps-admin/bulk/(:any)'] = "admin/bulkorder/view_bulk_order/$1";
$route['wps-admin/bulk/disp_bulk_order/(:any)'] = "admin/bulkorder/disp_bulk_order/$1";
$route['wps-admin/bulk/action_update_bulk_status/(:any)'] = "admin/bulkorder/action_update_bulk_status/$1";
$route['wps-admin/bulkorder_old/(:any)'] = "admin/bulkorder_old/$1";
$route['wps-admin/bulkorder_old/action_update_bulk_status/(:any)'] = "admin/bulkorder_old/action_update_bulk_status/$1";
$route['wps-admin/bulkorder_dispatch'] = "admin/bulkorder_dispatch";
$route['wps-admin/bulkorder_dispatch/action_update_bulk_status/(:any)'] = "admin/bulkorder_dispatch/action_update_bulk_status/$1";
$route['wps-admin/bulkorder_cancel'] = "admin/bulkorder_cancel";
$route['wps-admin/bulkorder_cancel/action_update_bulk_status/(:any)'] = "admin/bulkorder_cancel/action_update_bulk_status/$1";
$route['wps-admin/transaction']="admin/transaction";
$route['wps-admin/vendors']="admin/vendors";
$route['wps-vendor/payment/request']="admin/payment";
$route['wps-admin/payment/change-request-status']="admin/payment/change_request_status";
$route['wps-admin/testimonial']="admin/testimonial";
$route['wps-admin/add/testimonial']='admin/testimonial/add_new_testimonial';
$route['wps-admin/add/testimonial/action']='admin/testimonial/add_new_testimonial_action';
$route['wps-admin/vendor/make-inactive/(:any)']="admin/vendors/make_inactive/$1";
$route['wps-admin/vendors/unverified']='admin/vendors/unverified_vendors';
$route['wps-admin/vendor/make-active/(:any)']="admin/vendors/make_active/$1";

$route['wps-admin/delete/testimonial/(:any)']="admin/testimonial/delete_testimonial/$1";

$route['wps-admin/order/pending']="admin/orders/pending_orders";
$route['wps-admin/order/dispatched']="admin/orders/dispatched_orders";
$route['wps-admin/order/cancel']="admin/orders/cancel_orders";
$route['wps-admin/order/delivered']="admin/orders/delivered_orders";

$route['wps-admin/top/ten-link']="admin/top_ten_link";
$route['wps-admin/top-ten-link/add/action']="admin/top_ten_link/add_new_top_ten";

$route['wps-admin/brand']="admin/brand";
$route['wps-admin/brand/action']="admin/brand/add_brand";
$route['wbl-admin/brand/delete/brand/(:any)']="admin/brand/delete_brand/$1";

$route['wps-admin/products/addhsncode']="admin/products/add_hsn_code";




$route['wps-admin/products/set/arrival/(:any)']="admin/products/set_as_arrival_prod/$1";
$route['wps-admin/products/set/sale/(:any)']="admin/products/set_as_sale_prod/$1";
$route['wps-admin/products/unset/arrival/(:any)']="admin/products/unset_as_arrival_prod/$1";
$route['wps-admin/products/unset/sale/(:any)']="admin/products/unset_as_sale_prod/$1";

$route['wps-admin/products/set/todaysdeal/(:any)']="admin/products/set_as_todaysdeal_prod/$1";
$route['wps-admin/products/unset/todaysdeal/(:any)']="admin/products/unset_as_todaysdeal_prod/$1";


$route['wps-admin/product/delete/item/(:any)']="admin/products/delete_product/$1";

$route['wps-admin/social_links']="admin/social_links";
$route['wps-admin/social_links/edit']="admin/social_links/edit";


$route['wps-admin/docverif/view-document/(:any)']="admin/Docverif/view_codument/$1";
$route['wps-admin/docverif/verifydocnow/(:any)']="admin/Docverif/verifydocnow/$1";

$route['wps-admin/product/changestatus/item']="admin/products/change_status_prod";
$route['wps-admin/update/best-seller/limit']="admin/update_best_seller_limit";

$route['wps-admin/products/set/seasonal-delights/(:any)']="admin/products/set_seasonal_delight/$1";
$route['wps-admin/products/unset/seasonal-delights/(:any)']="admin/products/unset_seasonal_delight/$1";

$route['wps-admin/orders/vieworderbyvendor/(:any)/(:any)']="admin/orders/vieworderbyvendor/$1/$2";
$route['wps-admin/orders/vieworderandupload/(:any)']="admin/orders/vieworderandupload/$1";

// query by raaz for vendor
$route['wps-vendor'] = "vendor";
$route['wps-vendor/dashboard'] = "vendor/dashboard";

$route['wps-vendor/bulk/(:any)'] = "vendor/bulkorder/view_bulk_order/$1";
$route['wps-vendor/bulk/disp_bulk_order/(:any)'] = "vendor/bulkorder/disp_bulk_order/$1";
$route['wps-vendor/bulk/new-order/action_update_bulk_status'] = "vendor/bulkorder/action_update_bulk_status";
$route['wps-vendor/bulkorder_old'] = "vendor/bulkorder_old";
$route['wps-vendor/bulkorder_old/action_update_bulk_status'] = "vendor/bulkorder_old/action_update_bulk_status";
$route['wps-vendor/bulkorder_dispatch'] = "vendor/bulkorder_dispatch";
$route['wps-vendor/bulkorder_dispatch/action_update_bulk_status'] = "vendor/bulkorder_dispatch/action_update_bulk_status";
$route['wps-vendor/bulkorder_cancel'] = "vendor/bulkorder_cancel";
$route['wps-vendor/bulkorder_cancel/action_update_bulk_status'] = "vendor/bulkorder_cancel/action_update_bulk_status";
$route['wps-vendor/add_bulk_enquiry']="wps-vendor/products/add_bulk_enquiry";

$route['wps-vendor/forgot-password'] = "vendor/forgotten_password";
$route['wps-vendor/dashboard/(:any)'] = "vendor/dashboard/$1";

$route['wps-vendor/category'] = "vendor/category";
$route['wps-vendor/category/(:any)/(:any)'] = "vendor/category/$1/$2";

$route['wps-vendor/subadmin/(:any)'] = "vendor/subadmin/$1";
$route['wps-vendor/subadmin/(:any)/(:any)'] = "vendor/subadmin/$1/$2";

$route['wps-vendor/enquiry/(:any)'] = "vendor/enquiry/$1";
$route['wps-vendor/enquiry/(:any)/(:any)'] = "vendor/enquiry/$1/$2";

$route['wps-vendor/staticpages/(:any)/(:any)'] = "vendor/staticpages/$1/$2";

$route['wps-vendor/products'] = "vendor/products";
$route['wps-vendor/products/(:any)/(:any)'] = "vendor/products/$1/$2";

$route['wps-vendor/discountcoupon'] = "vendor/discountcoupon";
$route['wps-vendor/discountcoupon/(:any)/(:any)'] = "vendor/discountcoupon/$1/$2";

$route['wps-vendor/banners/(:any)'] = "vendor/banners/$1";
$route['wps-vendor/banners/(:any)/(:any)'] = "vendor/banners/$1/$2";

$route['wps-vendor/meta/(:any)/(:any)'] = "vendor/meta/$1/$2";

$route['wps-vendor/location/(:any)'] = "vendor/location/$1";
$route['wps-vendor/location/(:any)/(:any)'] = "vendor/location/$1/$2";

$route['wps-vendor/subloccontent/(:any)'] = "vendor/subloccontent/$1";
$route['wps-vendor/subloccontent/(:any)/(:any)'] = "vendor/subloccontent/$1/$2";

$route['wps-vendor/subcontent/(:any)'] = "vendor/subcontent/$1";
$route['wps-vendor/subcontent/(:any)/(:any)'] = "vendor/subcontent/$1/$2";

$route['wps-vendor/size/(:any)'] = "vendor/size/$1";
$route['wps-vendor/size/(:any)/(:any)'] = "vendor/size/$1/$2";

$route['wps-vendor/color/(:any)'] = "vendor/color/$1";
$route['wps-vendor/color/(:any)/(:any)'] = "vendor/color/$1/$2";


$route['wps-vendor/products/add'] = "vendor/products/add";
$route['wps-vendor/products/add/'] = "vendor/products/add";
$route['wps-vendor/search/product/search'] = "vendor/products/search";
$route['wps-vendor/members'] = "vendor/members";
$route['wps-vendor/logout'] = "vendor/admin/logout";
$route['wps-vendor/transaction'] = "vendor/transaction";
$route['wps-vendor/payment/request']="vendor/payment";
$route['wps-vendor/make/new/request']="vendor/payment/new_request_action";



$route['wps-vendor/vendor/documents']="vendor/document";
$route['wps-vendor/document/add']="vendor/document/new_add";
$route['wps-vendor/delete/document/(:any)']="vendor/document/delete_document/$1";

$route['wps-vendor/orders/index/(:any)/(:any)'] = "vendor/orders/index/$1/$2";
$route['wps-vendor/orders/index/(:any)']        = "vendor/orders/index/$1";

$route['wps-vendor/order/pending/(:any)']="vendor/orders/pending_orders/$1";
$route['wps-vendor/order/pending/(:any)/(:any)']="vendor/orders/pending_orders/$1/$2";

$route['wps-vendor/order/dispatched/(:any)']="vendor/orders/dispatched_orders/$1";
$route['wps-vendor/order/dispatched/(:any)/(:any)']="vendor/orders/dispatched_orders/$1/$2";

$route['wps-vendor/order/cancel/(:any)']="vendor/orders/cancel_orders/$1";
$route['wps-vendor/order/cancel/(:any)/(:any)']="vendor/orders/cancel_orders/$1/$2";

$route['wps-vendor/order/delivered/(:any)']="vendor/orders/delivered_orders/$1";
$route['wps-vendor/order/delivered/(:any)/(:any)']="vendor/orders/delivered_orders/$1/$2";

$route['wps-vendor/order/processing/(:any)']="vendor/orders/processing_orders/$1";
$route['wps-vendor/order/processing/(:any)/(:any)']="vendor/orders/processing_orders/$1/$2";

$route['wps-vendor/variant/(:any)']="vendor/variant/index/$1";
$route['wps-vander/variant/create/vendor/action']="vendor/variant/create_variant_by_product_id";
$route['wps-vendor/manage/image/variant-wise/(:any)']="vendor/variant/manage_image_by_variant/$1";
$route['wps-vendor/variant/get/variant-data-color-size-product']="vendor/variant/get_variant_by_size_color_productid";

$route['wps-vander/variant/create/image/action']="vendor/variant/image_upload_by_variant_action";

$route['wps-vendor/orders/vieworder/(:any)']="vendor/orders/vieworder/$1";

$route['wps-vendor/orders/filterorderhistorybydate']="vendor/orders/filterorderhistorybydate";











// for user routes
$route['add_bulk_enquiry']="products/add_bulk_enquiry";
$route['variant/color/code/image/gallery']="products/get_gallery_detail_page_by_color_code";
$route['data/filter']="products/filter_listing";

$route['blogs']="pages/blogs";

$route['todaydeals'] ="misc/todaydeals";

$route['bulkorder'] ="misc/bulkorder";

$route['best-seller'] ="products/best_seller_products";
$route['seasonal-delights'] ="products/seasonal_delights";
$route['share/friend-family'] ="users/share_friend_family";
$route['view-all-category'] ="products/view_all_category";

$route['mark-my-product-cancel/(:any)']="members/markmyproductcancel/$1";

$route['rewardspoint']="members/rewardspoint";

$route['reviewrate']="members/reviewrate";

$route['login/vendor']="vendorweb/index";
$route['login/vendor/login']="vendorweb/vendorloginaction";

$route['registartion/vendor']="vendorweb/vendorsignup";
$route['registartion/vendor/forgotpassword']="vendorweb/forgotpassword";
$route['registartion/resetpassword']="vendorweb/resetpassword";
$route['registartion/resetnow']="vendorweb/resetnow";


$route['forgetpassword']="users/forgetpassword";
$route['resetpassword']="users/resetpassword";
$route['user/resetnow/password']="users/resetnowpassword";
$route['my-orders/ordercancel']='members/ordercancel';



//$route['404_override'] = 'home';
$route['translate_uri_dashes'] = FALSE;

$route['payment/ccavenue_payment/(:any)'] = 'payment/ccavenue_payment/$1';
$route['payment/ccavenue_response'] = 'payment/ccavenue_response';
$route['payment/success'] = 'payment/success';
$route['payment/failure'] = 'payment/failure';
