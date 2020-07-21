<?php 


// Hide price all pages woocommerce 
add_filter( 'woocommerce_get_price_html', 'react2wp_woocommerce_hide_product_price' );
function react2wp_woocommerce_hide_product_price( $price ) {
    return '';
}
// remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
// remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_filter( 'woocommerce_cart_item_price', '__return_false' );
add_filter( 'woocommerce_cart_item_subtotal', '__return_false' );
//Remove price
add_filter( 'woocommerce_is_purchasable', '__return_false');

// Remvove vender and more product tab from product page
add_filter( 'woocommerce_product_tabs', 'woo_remove_tabs', 98 );
function woo_remove_tabs( $tabs ){
    if(is_product()){
      unset( $tabs['seller'] ); // Remove the description tab
      unset( $tabs['more_seller_product'] ); // Remove the additional information tab
    }
  	return $tabs;
}

 ?>