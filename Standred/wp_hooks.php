<?php 

function wp_customizer( $wp_customize ){

	// Copyright
	$wp_customize-> add_section( 'sec_copyright', array(
		'title' => __( 'Copyright', 'wp' ) ,
		'description' => __( 'Please, type here your copyright', 'wp' )
	) );

	$wp_customize-> add_setting( 'set_copyright', array(
		'type' => 'theme_mod',
		'default' => __( 'Copyright X - All Rights Reserved', 'wp' ),
		'sanitize_callback' => 'esc_attr'
	) );

	$wp_customize-> add_control( 'ctrl_copyright', array(
		'label' => __( 'Copyright Information', 'wp' ),
		'description' => __( 'Please, type your copyright here.', 'wp' ),
		'section' => 'sec_copyright',
		'settings' => 'set_copyright',
		'type' => 'text'
	) );

	// Map
	$wp_customize-> add_section( 'sec_map', array(
		'title' => __( 'Map', 'wp' ),
		'description' => __( 'The Map Section', 'wp' )
	) );

	// API Key
	$wp_customize-> add_setting( 'set_map_apikey', array(
		'type' => 'theme_mod',
		'default' => '',
		'sanitize_callback' => 'esc_attr'
	) );		

	$wp_customize-> add_control( 'ctrl_map_apikey', array(
		'label' => __( 'Google Maps API Key', 'wp' ),
		'description' => sprintf( __( 'Get your key <a target="_blank" href="%s">here</a>', 'wp' ), 'https://console.developers.google.com/flows/enableapi?apiid=maps_backend' ),
		'section' => 'sec_map',
		'settings' => 'set_map_apikey',
		'type' => 'text'
	) );

	// Map Address
	$wp_customize-> add_setting( 'set_map_address', array(
		'type' => 'theme_mod',
		'default' => '',
		'sanitize_callback' => 'esc_textarea'
	) );		

	$wp_customize-> add_control( 'ctrl_map_address', array(
		'label' => __( 'Type your address here', 'wp' ),
		'description' => __( 'No special characters allowed', 'wp' ),
		'section' => 'sec_map',
		'settings' => 'set_map_address',
		'type' => 'textarea'
	) );

}

add_action( 'customize_register', 'wp_customizer' ); 
?>
<!-- // Displaying  -->
   <div class="copyright col-sm-7 col-4">
       <p><?php echo get_theme_mod( 'set_copyright' ); ?></p>
    </div>

<!--callback map  -->
<section class="map">
<?php 
	$key = get_theme_mod( 'set_map_apikey' );
	$address = urlencode( get_theme_mod( 'set_map_address' ) ); ?>
	    <iframe
		     width="100%"
			 height="350"
			 frameborder="0" style="border:0"
			 src="https://www.google.com/maps/embed/v1/place?key=<?php echo $key; ?>&q=<?php echo $address; ?>&zoom=15" allowfullscreen>
	    </iframe>						
</section>


<?php 

// Including stylesheet and script files
function load_scripts(){
	wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js', array( 'jquery' ), '4.0.0', true );
	wp_enqueue_style( 'bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css', array(), '4.0.0', 'all' );
	wp_enqueue_style( 'template', get_template_directory_uri() . '/css/template.css', array(), '1.0', 'all' );
	wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/fitvids.js', array( 'jquery' ), null, true );
}
add_action( 'wp_enqueue_scripts', 'load_scripts' );


function wp_gutenberg_fonts(){
	wp_enqueue_style( 'lato-font', 'https://fonts.googleapis.com/css?family=Lato:400,900' );
	wp_enqueue_style( 'oswald-font', 'https://fonts.googleapis.com/css?family=Oswald:200,400,900' );
}
add_action( 'enqueue_block_editor_assets', 'wp_gutenberg_fonts' );


// Main configuration function
function wp_config(){

	// Registering our menus
	register_nav_menus(
		array(
			'my_main_menu' => __( 'Main Menu', 'wp' ),
			'footer_menu' => __( 'Footer Menu', 'wp' )
		)
	);

	// Displaying menu 
	 // $args = array('theme_location' => 'primary');  wp_nav_menu(  $args ); 
	 // wp_nav_menu( array( 'theme_location' => 'my_main_menu' ) ); 


	$args = array(
		'height' => 225,
		'width' => 1920
	);
	add_theme_support( 'custom-header', $args );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array( 'video', 'image') );
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-logo', array(
		'height' => 110,
		'width' => 200
	) );
	// Displaying logo  the_custom_logo(); 

	$textdomain = 'wp';
	load_theme_textdomain( $textdomain, get_template_directory() . '/languages/' );

	// Support for Gutenberg features
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-color-palette', array(
		array(
			'name' => __( 'Blood Red', 'wp' ),
			'slug' => 'blood-red',
			'color' => '#b9121b'
		),
		array(
			'name' => __( 'White Color', 'wp' ),
			'slug' => 'white',
			'color' => '#ffffff'
		)
	) );
	add_theme_support('post-thumbnails');
    the_post_thumbnail( 'thumbnail' );    
	the_post_thumbnail( 'medium' );        
	the_post_thumbnail( 'medium_large' );  
	the_post_thumbnail( 'large' );         
	the_post_thumbnail( 'full' );          
    add_theme_support( 'post-formats', array( 'aside', 'gallery','link'));

	add_theme_support( 'disable-custom-colors' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'css/style-editor.css' );
	add_theme_support( 'wp-block-styles' );
    add_theme_support( 'wp-background-image' );
 
}
add_action( 'after_setup_theme', 'wp_config', 0 );


// Customize excerpt word count length
function custom_excerpt_length() {
	return 22;
}
add_filter('excerpt_length', 'custom_excerpt_length');

 // custome experts 
function new_excerpt_more($more) {
   global $post;
   return '… <a href="'. get_permalink($post->ID) . '">' . 'Read More &raquo;' . '</a>';
   }
   add_filter('excerpt_more', 'new_excerpt_more');


//  Generate breadcrumbs
function get_breadcrumb() {
    echo '<a href="'.home_url().'" rel="nofollow">Home</a>';
    if (is_category() || is_single()) {
        echo "&nbsp;&nbsp;&#47;&nbsp;&nbsp;";
        the_category(' &nbsp;&nbsp;&#47;&nbsp;&nbsp; ');
            if (is_single()) {
                echo " &nbsp;&nbsp;&#47;&nbsp;&nbsp; ";
                the_title();
            }
    } elseif (is_page()) {
        echo "&nbsp;&nbsp;&#47;&nbsp;&nbsp;";
        echo the_title();
    } elseif (is_search()) {
        echo "&nbsp;&nbsp;&#47;&nbsp;&nbsp;Search Results for... ";
        echo '"<em>';
        echo the_search_query();
        echo '</em>"';
    }
}

?>

<!-- Displaying breadcrumb single.php
<style>
 .breadcrumb {
    padding: 8px 15px;
    margin-bottom: 20px;
    list-style: none;
    background-color: #f5f5f5;
    border-radius: 0px;
 }
 .breadcrumb a {
    color: #1e7e34;
    text-decoration: none;
 }
 </style>-->
<div class="breadcrumb"><?php get_breadcrumb(); ?></div>

<?php 
// Registering our sidebars

function wp_sidebars(){
	register_sidebar(
		array(
			'name' => __( 'Home Page Sidebar', 'wp' ),
			'id' => 'sidebar-1',
			'description' => __( 'This is the Home Page Sidebar. You can add your widgets here. ' , 'wp' ),
			'before_widget' => '<div class="widget-wrapper">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>'
		)
	);
	register_sidebar(
		array(
			'name' => __( 'Blog Sidebar', 'wp' ),
			'id' => 'sidebar-2',
			'description' => __( 'This is the Blog Sidebar. You can add your widgets here. ', 'wp' ),
			'before_widget' => '<div class="widget-wrapper">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>'
		)
	);
	register_sidebar(
		array(
			'name' => __( 'Service 1', 'wp' ),
			'id' => 'services-1',
			'description' => __( 'First Services Area. ', 'wp' ),
			'before_widget' => '<div class="widget-wrapper">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>'
		)
	);
	register_sidebar(
		array(
			'name' => __( 'Service 2', 'wp' ),
			'id' => 'services-2',
			'description' => __( 'Second Services Area. ', 'wp' ),
			'before_widget' => '<div class="widget-wrapper">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>'
		)
	);
	register_sidebar(
		array(
			'name' => __( 'Service 3' , 'wp' ),
			'id' => 'services-3',
			'description' => __( 'Third Services Area. ', 'wp' ),
			'before_widget' => '<div class="widget-wrapper">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>'
		)
	);
	register_sidebar(
		array(
			'name' => __( 'Social Media Icons', 'wp' ),
			'id' => 'social-media',
			'description' => __( 'Social Media Icons Widget Area. Drag and drop your widgets here. ', 'wp' ),
			'before_widget' => '<div class="widget-wrapper">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>'
		)
	);
	register_sidebar( array(
		'name' => 'Footer Area 1',
		'id' => 'footer1',
		'before_widget' => '<div class="widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	
	register_sidebar( array(
		'name' => 'Footer Area 2',
		'id' => 'footer2',
		'before_widget' => '<div class="widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	
	register_sidebar( array(
		'name' => 'Footer Area 3',
		'id' => 'footer3',
		'before_widget' => '<div class="widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	
	register_sidebar( array(
		'name' => 'Footer Area 4',
		'id' => 'footer4',
		'before_widget' => '<div class="widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	
}
add_action( 'widgets_init', 'wp_sidebars' );


//Displaying wegites 
 // Checks if there's a widget area with id sidebar-2
if( is_active_sidebar( 'sidebar-2' ) ){
	// If we find it, load its widgets
	dynamic_sidebar( 'sidebar-2' );
}

if (is_active_sidebar('footer4')) : ?>
	<div class="footer-widget-area">
	 <?php dynamic_sidebar('footer4'); ?>
	</div>
<?php endif; 


// Shortcode 

function myShortCode(){
  	echo strtoupper("<strong>here i am trying to display shortcode demo function-php with the help of hooks add_shortcode</strong>");
}
add_shortcode('MyShortcodefunction-php','myShortCode');

// Display [MyShortcodefunction-php]
// do_shortcode['MyShortcodefunction-php'];




// Register Custom Post Type
function wp_custom_post_type() {

	/**
	 * Post Type: Movies.
	 */

	$labels = [
		"name" => __( "Movies", "wp_custom_post_type" ),
		"singular_name" => __( "Movies", "wp_custom_post_type" ),
		"menu_name" => __( "My Movies", "wp_custom_post_type" ),
		"all_items" => __( "All Movies", "wp_custom_post_type" ),
		"add_new" => __( "Add New", "wp_custom_post_type" ),
		"add_new_item" => __( "Add New Movie", "wp_custom_post_type" ),
		"edit_item" => __( "Edit Movie", "wp_custom_post_type" ),
		"new_item" => __( "New Movie", "wp_custom_post_type" ),
		"view_item" => __( "View Movie", "wp_custom_post_type" ),
		"view_items" => __( "View Movies", "wp_custom_post_type" ),
		"search_items" => __( "Search Movies", "wp_custom_post_type" ),
		"not_found" => __( "No Movies found", "wp_custom_post_type" ),
		"not_found_in_trash" => __( "No Movies found  Trash", "wp_custom_post_type" ),
		"parent" => __( "Parent Movie", "wp_custom_post_type" ),
		"featured_image" => __( "Feature image for this No Movies found", "wp_custom_post_type" ),
		"set_featured_image" => __( "Set feature image for this movie", "wp_custom_post_type" ),
		"remove_featured_image" => __( "Remove feature image for this movie", "wp_custom_post_type" ),
		"use_featured_image" => __( "Use as feature image for this movie", "wp_custom_post_type" ),
		"archives" => __( "Movie archive", "wp_custom_post_type" ),
		"insert_into_item" => __( "Insert into movie", "wp_custom_post_type" ),
		"uploaded_to_this_item" => __( "Uploaded to this movie", "wp_custom_post_type" ),
		"filter_items_list" => __( "Filter movie list", "wp_custom_post_type" ),
		"items_list_navigation" => __( "Movies list navigation", "wp_custom_post_type" ),
		"items_list" => __( "Movies list", "wp_custom_post_type" ),
		"attributes" => __( "Movies attribute", "wp_custom_post_type" ),
		"name_admin_bar" => __( "Movie", "wp_custom_post_type" ),
		"item_published" => __( "Movie Published", "wp_custom_post_type" ),
		"item_published_privately" => __( "Movie Published privately", "wp_custom_post_type" ),
		"item_reverted_to_draft" => __( "Movie reverted to draft", "wp_custom_post_type" ),
		"item_scheduled" => __( "Movie scheduled", "wp_custom_post_type" ),
		"item_updated" => __( "Movie updated", "wp_custom_post_type" ),
		"parent_item_colon" => __( "Parent Movie", "wp_custom_post_type" ),
	];

	$args = [
		"label" => __( "Movies", "wp_custom_post_type" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => [ "slug" => "movies", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields", "comments", "revisions", "author", "page-attributes", "post-formats" ],
		"taxonomies" => [ "category", "post_tag" ],
	];

	register_post_type( "movies", $args );
}

// Register Custom Taxonomy
function custom_taxonomy() {

	$labels = array(
		'name'                       => _x( 'movies', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'movie', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Taxonomy', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'movies', array( '' ), $args );
}
add_action( 'init', 'custom_taxonomy', 0 );

add_action( 'init', 'wp_custom_post_type' );