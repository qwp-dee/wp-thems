<?php

/*
Descriptions : Custom Metabox Repeater, Image, Title, Content,

*/


/*Load admin script for wp_enqueue_media scripts*/

if (!function_exists('stokedagency_admin_repeater_script_fn')) :
    function stokedagency_admin_repeater_script_fn(){
        wp_enqueue_media();
        wp_enqueue_script( 'admin-repeater-js', SA_THEME_URI . '/admin/assets/js/wp-media.js', array('jquery'), '',true );
        wp_localize_script( 'admin-repeater-js', 'wp_media', array(
            'title' => __( "Choose an image", "ask" ),
            'btn_txt' => __( "Use image", "ask" ),
        ) );
    }
    add_action( 'admin_enqueue_scripts', 'stokedagency_admin_repeater_script_fn' );
endif;

/* End Load admin script for wp_enqueue_media scripts*/

/*Custom metabox repeater filed*/
/*Create page metabox */
if(!function_exists('banner__image_meta_box_fn')) :

 function banner__image_meta_box_fn(){
       add_meta_box("banner_image", "Banner image", "banner__image_fn", "page", "normal", "high", null);
   }
 add_action("add_meta_boxes", "banner__image_meta_box_fn");

endif; /*End Create page metabox */

/*Metabox callback function*/

if(!function_exists('banner__image_fn')) :
function banner__image_fn(){ 
   /*<!-- referance metabox start -->*/
    global $post;
    $stoke_meta = get_post_meta( $post->ID );
    $reference_group = get_post_meta($post->ID, 'reference_group', true);
    wp_nonce_field( 'repeatable_meta_box_nonce', 'repeatable_meta_box_nonce' );
?>
	<table id="repeatable-fieldset-one" class="widefat fixed" width="100%">
	   <col width="25%">
	   <col width="25%">
	   <col width="40%">
	   <col width="10%">
	   <tbody id="sortable">
	      <?php
	         if ( $reference_group ) :
	          foreach ( $reference_group as $field ) {
	            $field['logo']    = isset( $field['logo'] )? $field['logo'] : false;
	         ?>
	      <?php wp_enqueue_media(); ?>
	      <tr class="alternate">
	         <td class="repeater-logo-wrapper">
	            <?php if($field['logo'] ) { ?>
	            <div>
	               <img src="<?php echo esc_url(  $image = wp_get_attachment_thumb_url( $field['logo'] )  ); ?>" width="100px" height="100px" />
	            </div>
	            <?php } ?>  
	            <input type="hidden" class="wp-logo" name="logo[]" value="<?php if( $field['logo'] != '') echo esc_attr( $field['logo'] ); ?>" />
	            <button type="button" class="upload_image_button button" style="display:<?php echo ( $field['logo'] )? 'none' : 'block';?>"><?php _e( 'Add image', 'stokedagency' ); ?></button>
	            <button type="button" class="remove_image_button button" style="display:<?php echo ( !$field['logo'] )? 'none' : 'block';?>;"><?php _e( 'Remove image', 'stokedagency' ); ?></button>  
	         </td>
	         <td>
	            <strong>Heading : </strong>
	            <input type="text" class="widefat"  placeholder="Title" name="Reference_Title[]" value="<?php if($field['Reference_Title'] != '') echo esc_attr( $field['Reference_Title'] ); ?>" />
	         </td>
	         <td>
	            <strong>Description : </strong>
	            <textarea placeholder="Description" cols="45" rows="2"  class="widefat" name="Reference_Description[]"> <?php if ($field['Reference_Description'] != '') echo esc_attr( $field['Reference_Description'] ); ?> </textarea>
	         </td>
	         <td class="action-meta" style="float: right; margin-right: 10px; margin-top: 10px; width: 20px;">
	            <a class=" remove-row" href="#1"><span class="dashicons dashicons-trash"></span></a>
	         </td>
	      </tr>
	      <?php
	         }
	         else :
	         // show a blank one
	         ?>
	      <tr class="alternate">
	         <td class="repeater-logo-wrapper">
	            <input type="hidden" class="wp-logo" name="logo[]" />            
	            <button type="button" class="upload_image_button button"><?php _e( 'Add image', 'stokedagency' ); ?></button>
	            <button type="button" class="remove_image_button button" style="display:none;"><?php _e( 'Remove image', 'stokedagency' ); ?></button>
	         </td>
	      </tr>
	      <tr class="alternate">
	         <strong>Heading : </strong>
	         <td><input type="text" class="widefat"  placeholder="Title" title="Title" name="Reference_Title[]" /></td>
	      </tr>
	      <tr class="alternate">
	         <td> 
	            <strong>Description : </strong>
	            <textarea  placeholder="Description" class="widefat" cols="45" rows="2"  class="all-options" name="Reference_Description[]">  </textarea>
	         </td>
	      </tr>
	      <tr class="alternate">
	         <td class="action-meta" style="float: right; margin-right: 10px; margin-top: 10px; width: 20px;"><a class="button  cmb-remove-row-button button-disabled" href="#"><span class="dashicons dashicons-trash"></span></a></td>
	      </tr>
	      <?php endif; ?>
	      <!-- empty hidden one for jQuery -->
	      <tr class="empty-row screen-reader-text alternate">
	         <td class="repeater-logo-wrapper">
	            <input type="hidden" class="wp-logo" name="logo[]" />            
	            <button type="button" class="upload_image_button button"><?php _e( 'Add image', 'stokedagency' ); ?></button>
	            <button type="button" class="remove_image_button button" style="display:none;"><?php _e( 'Remove image', 'stokedagency' ); ?></button>            
	         </td>
	         <td>
	            <strong>Heading : </strong>
	            <input type="text" class="widefat" placeholder="Title"  name="Reference_Title[]"/>
	         </td>
	         <td>
	            <strong>Description : </strong>
	            <textarea placeholder="Description" class="widefat" cols="45" rows="2" name="Reference_Description[]">
	            </textarea>
	         </td>
	         <td class="action-meta" style="float: right; margin-right: 10px; margin-top: 10px; width: 20px;">
	            <a class="remove-row" href="#"><span class="dashicons dashicons-trash"></span></a>
	         </td>
	      </tr>
	   </tbody>
	</table><br/>
	<p><a id="add-row" class="button" href="#">Add referances</a></p>
<!-- referances metabox end -->

<?php   
} 

endif; /* End Metabox callback function*/

/*Save metabox value */

if(!function_exists('custom_repeatable_meta_box_save')) :

function custom_repeatable_meta_box_save($post_id) {
       if ( ! isset( $_POST['repeatable_meta_box_nonce'] ) ||
       ! wp_verify_nonce( $_POST['repeatable_meta_box_nonce'], 'repeatable_meta_box_nonce' ) )
           return;
   
       if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
           return;
   
       if (!current_user_can('edit_post', $post_id))
           return;
   
       $old = get_post_meta($post_id, 'reference_group', true);
       $new = array();
       $title = $_POST['Reference_Title'];
       $description = $_POST['Reference_Description'];
       $logo = $_POST['logo'];
   
        $count = count( $title );
        for ( $i = 0; $i < $count; $i++ ) {
           if ( $title[$i] != '' ) :
               $new[$i]['Reference_Title'] = stripslashes( strip_tags( $title[$i] ) );
               $new[$i]['Reference_Description'] = stripslashes( $description[$i] ); 
   
               if ( $logo[$i] == '' )
                   $new[$i]['logo'] = '';
              else
                  $new[$i]['logo'] = abs( $logo[$i] ); 
   
           endif;
       }
   
       if ( !empty( $new ) && $new != $old )
           update_post_meta( $post_id, 'reference_group', $new );
   
       elseif ( empty($new) && $old )
           delete_post_meta( $post_id, 'reference_group', $old );
}
add_action('save_post', 'custom_repeatable_meta_box_save');
endif; /*End Save metabox value */
