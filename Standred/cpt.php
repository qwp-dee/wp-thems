<?php
/**
 * porto Careers Post type
 * @package porto
 * @copyright Copyright (C) 2020
 */
/* ---------------------------------------------------------------------------
* JC Careers Custom Post type
* --------------------------------------------------------------------------- */
if ( ! class_exists( 'JC_Careers_Post_Type' ) ) :

	class JC_Careers_Post_Type {
		
		public function __construct()
      	 {
			// Adds the JC Careers post type
			add_action( 'init', array( &$this, 'JCCareersInit' ) );
			add_action('after_theme_switch', array( &$this, 'JCCustomFlushRulesCareers') );


			// Add the data to the custom columns for the Partners post type:
			add_filter( 'manage_edit-career_columns', array( &$this, 'JCCustomEditCareersColumns'), 10, 1 );

			add_action( 'manage_career_posts_custom_column' , array( &$this, 'JCCareersColumn'), 10, 1 );

			// Show Partners post counts in the dashboard
			add_action( 'dashboard_glance_items', array( &$this, 'JCAddCareersCounts' ) );
			add_action('admin_head', array(&$this, 'JCCareerIcon'));
		}
		/*-----------------------------------------------------------------------------------
		* Function : JCCareersInit
		* Used to register post type
		*-----------------------------------------------------------------------------------*/
		public function JCCareersInit() {
			$Career_labels = array(
				'name'               	=> __( 'Careers', 'porto' ),
				'singular_name'      	=> __( 'Career', 'porto' ),
				'menu_name'          	=> __( 'Careers', 'porto' ),
				'name_admin_bar'     	=> __( 'Careers', 'porto' ),
				'add_new'            	=> __( 'Add Careers', 'porto' ),
				'add_new_item'       	=> __( 'Add New Careers', 'porto' ),
				'new_item'           	=> __( 'New Careers', 'porto' ),
				'edit_item'          	=> __( 'Edit Careers', 'porto' ),
				'view_item'          	=> __( 'View Careers', 'porto' ),
				'all_items'          	=> __( 'All Careers', 'porto' ),
				'search_items'       	=> __( 'Search Careers', 'porto' ),
				'parent_item_colon'  	=> __( 'Parent Careers:', 'porto' ),
				'not_found'          	=> __( 'No Careers found.', 'porto' ),
				'not_found_in_trash' 	=> __( 'No Careers found in Trash.', 'porto'),
			);
			$Career_args = array(
				'labels'             => $Career_labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'career' ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => true,
				'menu_position'		 =>	5,
				'menu_icon'			 => 'dashicons-universal-access',
				'supports'           => array('title','page-attributes','editor')
			);

			register_post_type( 'career', $Career_args );
		}	//End JCCareersInit

		/*-----------------------------------------------------------------------------------
		* Function : JCCustomFlushRulesCareers
		* post type so the rules can be flushed.
		*-----------------------------------------------------------------------------------*/
		function JCCustomFlushRulesCareers(){
			//defines the post type so the rules can be flushed.
			JCCareersInit();
			//and flush the rules.
			flush_rewrite_rules();
		}

		/*-----------------------------------------------------------------------------------
		* Function : JCCustomEditCareersColumns
		* Add Column in Partner listing
		*-----------------------------------------------------------------------------------*/
		function JCCustomEditCareersColumns($columns) {
			$columns_careers = array();
			foreach($columns as $key => $title){
				if($key == 'date'){
					$columns_careers['content'] = __( 'Content', 'porto' );
					$columns_careers['order'] =  __( 'Order', 'porto' );
				}
				$columns_careers[$key] = $title;
			}
			
		    return $columns_careers;
		}
		/*-----------------------------------------------------------------------------------
		* Function : JCCareersColumn
		* Add data to columns in Partner listing
		*-----------------------------------------------------------------------------------*/
		function JCCareersColumn( $column) {
			global $post;
		    switch ( $column ) {
		        case 'content' :
					echo $post->post_content;
		            break;
		        case 'order' :
					echo $post->menu_order;
		            break;
		    }
		}
		/*-----------------------------------------------------------------------------------
		* Function : JCAddCareersCounts
		* Add DC Partner count to "Right Now" Dashboard Widget
		*-----------------------------------------------------------------------------------*/
		function JCAddCareersCounts() {
			if ( ! post_type_exists( 'career' ) ) {
				return;
			}

			$num_posts = wp_count_posts( 'career' );
			$num = number_format_i18n( $num_posts->publish );
			$text = _n( '\'career\' Item', '\'career\' Items', intval($num_posts->publish) );
			if ( current_user_can( 'edit_posts' ) ) {
				$output = "<a href='edit.php?post_type=career'>$num $text</a>";
			}
			echo '<li class="post-count career-count">' . $output . '</li>';

			if ($num_posts->pending > 0) {
				$num = number_format_i18n( $num_posts->pending );
				$text = _n( '\'career\' Item Pending', '\'career\' Items Pending', intval($num_posts->pending) );
				if ( current_user_can( 'edit_posts' ) ) {
					$num = "<a href='edit.php?post_status=pending&post_type=career'>$num</a>";
				}
				echo '<li class="post-count career-count">' . $output . '</li>';
			}
		}

		/*-----------------------------------------------------------------------------------
		* Function : JCCareerIcon
		* Displays the custom post type icon in the dashboard
		*-----------------------------------------------------------------------------------*/
        function JCCareerIcon() {
            ?>
            <style type="text/css" media="screen">
                .career-count a:before {
                    content: "\f338" !important;
                }
            </style>
        <?php
        }
	}
	new JC_Careers_Post_Type;
endif;