<?php 


function theme_child_scripts_styles(){ 
  // Load custom js file
 wp_enqueue_script( 'buddyboss-child-js', get_stylesheet_directory_uri().'/assets/js/custom.js', '', '1.0.0', true );

  // ajax file
  wp_localize_script( 'buddyboss-child-js', 'wasabih', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'theme_child_scripts_styles');




/*save drag & drop order*/
function bbc_save_item_order() {
  $order  = $_POST['order'];
  $order = json_decode($order, true);
  foreach ($order as $k => $id) {
      update_post_meta($id, '_bbc_experience_order', $k);
  }
  wp_send_json_success();
}
add_action('wp_ajax_item_sort', 'bbc_save_item_order');
add_action('wp_ajax_nopriv_item_sort', 'bbc_save_item_order'); 







