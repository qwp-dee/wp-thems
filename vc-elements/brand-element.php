<?php if ( !class_exists( 'Taxonomy_Term_Addon' ) ) {
  class Taxonomy_Term_Addon {

    // Constructor for the taxonomy term listing. Loads options and hooks in the init method.
    public function __construct() { 
      add_action( 'vc_before_init', array( $this, 'termlisting' ) );
    }

    // Constructor for the taxonomy term listing. Loads options and hooks in the init method.
    public function checkBoolean( $string ) { 
      if( is_string($string) && $string == '1' ||
          is_string($string) && strtolower($string) == 'true' ||
          is_bool($string) && $string === TRUE ){
        return TRUE;
      }

      return FALSE;

    }

    // Include or mapping
    function termlisting() {
      $taxonomies = get_terms( array(
        'taxonomy' => 'brand',
        'hide_empty' => false,
        'meta_key'      => 'display_order_number',
        'meta_compare'  => 'NUMERIC',
        'orderby'       => 'meta_value_num',
        'order'         => 'ASC',
        // 'meta_query'=> array(
        //   array(
        //     'key' => 'display_on_home',
        //     'value' => 'Yes',
        //     'compare' => '==',  
        //   )
        // ) 
    ) );
     $options = array();
    foreach ($taxonomies as $value) {
      $termId = $value->term_id;
      $termName = $value->name;
      $options[$termId] = $termName;
    }
      vc_map( array(
        'name' => __('Brand Listing','taxonomy-term-listing-visual-composer-addon'),
        'base' => 'taxonomy_term',
        'icon' => TAXONOMY_LISTING_ADDON_PLUGIN_URL . '/images/icon-taxonomy-listing.png',
        'class' => '',
        'category' => 'Content',
        'params' => array(
          array(
            'type' => 'Taxonomy_Names',
            'holder' => 'div',
            'class' => '',
            'heading' => __( '', 'taxonomy-term-listing-visual-composer-addon' ),
            'param_name' => 'taxonomy_names',
            'value' => '',
            'description' => __('Select desired taxonomy name','taxonomy-term-listing-visual-composer-addon'),
          ),
          array( 
            'type' => 'dropdown',
            'class' => '',
            'heading' => __( '', 'taxonomy-term-listing-visual-composer-addon' ),
            'param_name' => 'order',
            'value' => array(
              'Ascending' => 'ASC',
              'Descending' => 'DESC'
            ),
            'description' => '',
          ),
          array(
            'type' => 'include_child_category',
            'class' => '',
            'heading' => __( '', 'taxonomy-term-listing-visual-composer-addon' ),
            'param_name' => 'include_subcategory',
            'value' => '',
            'description' => '',
            'admin_label' => 'false',
          ),
          array(
            'type' => 'count_display',
            'class' => '',
            'heading' => __( '', 'taxonomy-term-listing-visual-composer-addon' ),
            'param_name' => 'count',
            'value' => '',
            'description' => '',
            'admin_label' => 'false',
          ),
          array(
            'type' => 'Hide_empty',
            'class' => '',
            'heading' => __( '', 'taxonomy-term-listing-visual-composer-addon' ),
            'param_name' => 'hide_empty',
            'value' => '',
            'description' => '',
            'admin_label' => 'false',
          ),
          array(
            'type' => 'textfield',
            'class' => '',
            'heading' => __('Enter Parent term Id','taxonomy-term-listing-visual-composer-addon'),
            'param_name' => 'specific_subcategory',
            'value' => '',
            'description' => __('include any specific subcategory','taxonomy-term-listing-visual-composer-addon'),
            'admin_label' => 'false',
          ),
          array(
            'type' => 'textfield',
            'class' => '',
            'heading' => __('Extra Class Name','taxonomy-term-listing-visual-composer-addon'),
            'param_name' => 'extra_class_name',
            'value' => '',
            'description' => __('For styling any particular element','taxonomy-term-listing-visual-composer-addon'),
            'admin_label' => 'false',
          ),
          array( 
            'type' => 'dropdown_multi',
            'class' => '',
            'heading' => __( 'Select Brands', 'taxonomy-term-listing-visual-composer-addon' ),
            'param_name' => 'brand_id',
            'value' => $options,
            'description' => '',
          ),
        )
      ) );
    }

    function taxonomy_name_settings_field( $settings, $value ) {
      $data = '<div class="taxonomy_name_list">' . '<select name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-input wpb-select">';
      $data .= '<option value="">'.__('Select Taxonomy','taxonomy-term-listing-visual-composer-addon').'</option>';
      $post_types = get_post_types( array( 'public' => true ) );
      foreach ( $post_types as $key => $post_type_name ) {
        $taxonomy_names = get_object_taxonomies( $post_type_name );
        foreach( $taxonomy_names as $taxonomy_name ) {
          $data .= '<option value="' . $taxonomy_name . '"' . ( ( $taxonomy_name == $value ) ? 'selected' : '' ) . '>' . $taxonomy_name . '</option>';   
        }
      }
      $data .= '</select>' . '</div>'; ?>
      <script>
      (function( $ ) {
        jQuery('.taxonomy_name_list select').change(function(){
          var taxonomyValue = {
            action: "get_taxonomy_term_id",
            postdata: jQuery('.taxonomy_name_list select').val()
          }
          jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", taxonomyValue, function( response ) {
            jQuery('.parent_id_list select').empty().append(response);        
          } ); 
        });
        if ( jQuery('.taxonomy_name_list select').val() != "" ) {
          var taxonomyValue1 = {
            action: "get_taxonomy_term_id",
            postdata_selected: jQuery('.taxonomy_name_list select').val(),
            postdata_termselected: jQuery('.parent_id_list select').val()
          }
          jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", taxonomyValue1, function( response ) {
            jQuery('.parent_id_list select').empty().append(response);        
          } ); 
        }
      })( jQuery );
      </script>
      <?php return $data;
    }
   
    function include_child_settings_field( $settings, $value ) {
      $include_child_categories = '<div class="include-child"><input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value checkbox" type="checkbox" value="' . ( ( $value != "" ) ? $value : 1 ) . '" ' . ( $value == 1 ? checked : '' ) . '' . ( ( $value == "" ) ? checked : '' ) . ' >'.__('include Subcategory','taxonomy-term-listing-visual-composer-addon'). '</div>'; ?>
      <script>
      (function( $ ) {
        jQuery( 'input[name="include_subcategory"]' ).on( 'change', function() {
          this.value = this.checked ? 1 : 0 ;
        });
      })( jQuery );
      </script>
      <?php return $include_child_categories;
    }

    function count_display_settings_field( $settings, $value ) {
      $include_count_display = '<div class="include-count"><input name="'. esc_attr( $settings['param_name'] ) .'" class="wpb_vc_param_value checkbox" type="checkbox" value="' . ( ( $value != "" ) ? $value : 1 ) . '" ' . ( $value == 1 ? checked : '' ) . '' . ( ( $value == "" ) ? checked : '' ) . ' >'.__('show count','taxonomy-term-listing-visual-composer-addon') . '</div>'; ?>
      <script>
      (function( $ ) {
        jQuery( 'input[name="count"]' ).on( 'change', function() {
          this.value = this.checked ? 1 : 0 ;
        });
      })( jQuery );
      </script>
      <?php return $include_count_display;
    }

    

    function hide_empty_settings_field( $settings, $value ){
      $hide_empty_cat = '<div class="hide_empty_main"><input name="'. esc_attr( $settings['param_name'] ) .'" class="wpb_vc_param_value checkbox" type="checkbox" value="' . ( ( $value != "" ) ? $value : 1 ) . '" ' . ( $value == 1 ? checked : '' ) . '' . ( ( $value == "" ) ? checked : '' ) . ' >'.__('Hide Empty Category','taxonomy-term-listing-visual-composer-addon') . '</div>'; ?>
      <script>
      (function( $ ) {
        jQuery( 'input[name="hide_empty"]' ).on( 'change', function() {
          this.value = this.checked ? 1 : 0 ;
        });
      })( jQuery );
      </script>
      <?php return $hide_empty_cat;
    }

    function specific_subcategory_settings_field( $settings, $value ) {
      $specific_cat = '<div class="parent_id_list">' . '<select name="'. esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-input wpb-select">';
      $specific_cat .= '<option value="' . $value . '">'.__('Select Taxonomy first','taxonomy-term-listing-visual-composer-addon').'</option>';  
      $specific_cat .= '</select>' . '</div>';
      return $specific_cat;
    }

    // frontend view 
    function term_listing_func( $atts ) {
      global $post;

      $specific_subcategory = isset( $atts['specific_subcategory'] ) ? $atts['specific_subcategory'] : 0 ;
      $order_attr = ( isset( $atts['order'] ) ? $atts['order'] : 'ASC' );
      $brand_id = ( isset( $atts['brand_id'] ) ? $atts['brand_id'] : "" );
      $taxonomy_names_attr = ( isset( $atts['taxonomy_names'] ) ? $atts['taxonomy_names'] : NULL ); 
      $class = ( isset( $atts['extra_class_name']) ? "class = ".$atts['extra_class_name'] : "");
      $arguments = array( 'hide_empty' => $atts['hide_empty'], 'meta_key' => 'display_order_number', 'meta_compare'  => 'NUMERIC','orderby'       => 'meta_value_num', 'order' => $order_attr, 'parent'=> 0, 
      // 'meta_query'=> array(
      //     array(
      //       'key' => 'display_on_home',
      //       'value' => 'Yes',
      //       'compare' => '==',  
      //     )
      //   ) 
      );
      $post_id = NULL;
      if( !is_null($post) && isset($post->ID) ){
        $post_id = $post->ID;
      }

      if ( isset( $atts['specific_subcategory'] ) || $atts['include_subcategory'] == 1 ) {
        if ( isset( $atts['specific_subcategory'] ) ) {
          $arguments = array( 'hide_empty' => $atts['hide_empty'], 'order' => $order_attr, 'parent' => $specific_subcategory ,  'meta_key' => 'display_order_number', 'meta_compare'  => 'NUMERIC','orderby'       => 'meta_value_num', 
            // 'meta_query'=> array(
            //   array(
            //     'key' => 'display_on_home',
            //     'value' => 'Yes',
            //     'compare' => '==',  
            //   )
            // ) 
          ); 
        }
      
        $term = get_terms( $taxonomy_names_attr,$arguments );
        if(!empty($term)){
        $response = '';
        $response = '<div class="vc_taxonomy_listing one">';
        $response .= '<ul ' . $class . '>';
        
        if(!empty($brand_id)){
          $brandid = explode(",", $brand_id);
          foreach( $brandid as $bid ) {
            $bid = str_replace('"', ' ', $bid);
            $termarr = get_term_by('name', $bid , $taxonomy_names_attr);
            if(!empty($termarr)) {
              if(!empty(get_term_meta( $termarr->term_id, 'brand_thumbnail', true ))){
                  $thumbimg = wp_get_attachment_image ( get_term_meta( $termarr->term_id, 'brand_thumbnail', true ), 'home_brand' );
              } else {
                  $thumbimg = '<img src="'.site_url().'/app/uploads/2020/05/Brand-logo.jpg" class="attachment-prod_thumb size-prod_thumb wp-post-image" alt="dumm">';
              }
              $response .= '<li class="item"><a href="' . get_term_link( $termarr->term_id ) . '">' .$thumbimg.'<span class="btitle">'.$termarr->name.'</span></a></li>';
            }
          }
        } 
        else {
          foreach( $term as $terms ) {
           if( ( is_array($terms) && isset($terms['invalid_taxonomy']) ) || (is_object($terms) && isset($terms->invalid_taxonomy) ) || !isset($terms->term_id) || empty($terms->term_id) ){
                continue;
              }
              if(!empty(get_term_meta( $terms->term_id, 'brand_thumbnail', true ))){
                $thumbimg = wp_get_attachment_image ( get_term_meta( $terms->term_id, 'brand_thumbnail', true ), 'home_brand' );
              } else {
                  $thumbimg = '<img src="'.site_url().'/app/uploads/2020/05/Brand-logo.jpg" class="attachment-prod_thumb size-prod_thumb wp-post-image" alt="dumm">';
              }
              $response .= '<li class="item"><a href="' . get_term_link( $terms->term_id ) . '">' .$thumbimg. '<span class="btitle">'.$terms->name.'</span></a></li>';
          }
        }

        $response .= '</ul>';
        $response .= '</div>';
      }
        return $response;
      } else {
        $term = get_terms( $taxonomy_names_attr,$arguments );
        $response = '';
        $response = '<ul ' . $class . '>';
        $response = '<div class="vc_taxonomy_listing two">';
        foreach ($term as $terms ){
          if(!empty(get_term_meta( $terms->term_id, 'brand_thumbnail', true ))){
            $thumbimg = wp_get_attachment_image ( get_term_meta( $terms->term_id, 'brand_thumbnail', true ), 'home_brand' );
          } else {
              $thumbimg = '<img src="'.site_url().'/app/uploads/2020/05/Brand-logo.jpg" class="attachment-prod_thumb size-prod_thumb wp-post-image" alt="dumm">';
          }
          $response .= '<li class="item"><a href="' . get_term_link( $terms->term_id ) . '">' .$thumbimg . '<span class="btitle">'.$terms->name.'</a></li>';
        }
        $response .= '</ul>';
        $response .= '</div>';
        return $response;
      }
    }
  }
}
// Instantiate our class
$taxonomy_listing_obj = new Taxonomy_Term_Addon();  
vc_add_shortcode_param( 'Taxonomy_Names',  array($taxonomy_listing_obj, 'taxonomy_name_settings_field' ) );
vc_add_shortcode_param( 'include_child_category', array( $taxonomy_listing_obj, 'include_child_settings_field' ) );
vc_add_shortcode_param( 'count_display', array( $taxonomy_listing_obj, 'count_display_settings_field' ) );
vc_add_shortcode_param( 'Hide_empty', array( $taxonomy_listing_obj, 'hide_empty_settings_field' ) );
vc_add_shortcode_param( 'count_display', array( $taxonomy_listing_obj, 'count_display_settings_field' ) );
add_shortcode( 'taxonomy_term', array( $taxonomy_listing_obj, 'term_listing_func' ) );

// Ajax call for selection of parent term id. 
add_action( 'wp_ajax_get_taxonomy_term_id', 'get_taxonomy_term_id' );
add_action( 'wp_ajax_nopriv_get_taxonomy_term_id', 'get_taxonomy_term_id' );
function get_taxonomy_term_id() {
  global $wpdb;
  if ( isset( $_POST['postdata'] ) ) {
    $tax_name = sanitize_text_field( $_POST['postdata'] );
  }
  elseif ( isset( $_POST['postdata_selected'] ) ) {
    $tax_name = sanitize_text_field( $_POST['postdata_selected'] );
    $term_val = sanitize_text_field( $_POST['postdata_termselected'] );
  }
  $str="";
  if( ! empty( $tax_name ) ) {
    $arg = array( 'taxonomy' => $tax_name );
    $terms = get_categories( $arg );
    if ( isset( $_POST['postdata'] ) || isset( $_POST['postdata_termselected'] ) ) {
      $str .= '<option value="">Select Term</option>';
    }
    foreach( $terms as $term ) {
      if ( $term->parent == 0 ) {
        $str .= '<option value="' . $term->term_id . '" ' . ( $term->term_id == $term_val ? selected : '' ) . '>' . $term->name . '</option>';
      }
    }
  }
  echo $str;
  exit();
} 
// Create multi dropdown param type
vc_add_shortcode_param( 'dropdown_multi', 'dropdown_multi_settings_field' );
function dropdown_multi_settings_field( $param, $value ) {

    $param_line = '';
    $param_line .= '<select multiple name="'. esc_attr( $param['param_name'] ).'" class="wpb_vc_param_value wpb-input wpb-select '. esc_attr( $param['param_name'] ).' '. esc_attr($param['type']).'">';
    foreach ( $param['value'] as $text_val => $val ) {
        if ( is_numeric($text_val) && (is_string($val) || is_numeric($val)) ) {
            $text_val = $val;
        }
        $text_val = __($text_val, "js_composer");
        $selected = '';

        if(!is_array($value)) {
            $param_value_arr = explode(',',$value);
        } else {
            $param_value_arr = $value;
        }

        if ($value!=='' && in_array($val, $param_value_arr)) {
            $selected = ' selected="selected"';
        }
        $param_line .= '<option class="'.$val.'" value="'.$val.'"'.$selected.'>'.$text_val.'</option>';
    }
    $param_line .= '</select>';

    return  $param_line;
}