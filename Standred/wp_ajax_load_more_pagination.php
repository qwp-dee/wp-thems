<?php

/**
 * Template Name: Ajax-Load-More-Pagination Template


 * FIRST USE THIS CODE IN function.php file 

 add_action( 'wp_footer', 'my_action_javascript' ); // Write our JS below here

function my_action_javascript() { ?>
	<script type="text/javascript" >
	jQuery(document).ready(function($) {
		var page = 2;
		var post_count = jQuery("#posts").data('count');
		var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";

		jQuery("#load-post").click(function(){

			var data = {
				'action': 'my_action',
				'page': page
			};

		jQuery.post(ajaxurl, data, function(response) {
			jQuery("#posts").append(response);

				if (post_count == page) {
					jQuery("#load-post").hide();
				}
					console.log(page++);	
		});
	  });
	});
	</script> <?php
}

add_action( 'wp_ajax_my_action', 'my_action' );

function my_action() {
	
	$args  = array('post_type' => 'post',
			   		   'paged'=>$_POST['page'],

			   		  );
	$the_query = new WP_Query( $args );

		// the query
		$the_query = new WP_Query( $args ); ?>
		 
		<?php if ( $the_query->have_posts() ) : ?>
    	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
       		<h2><?php the_title(); ?></h2>

   		 <?php endwhile; ?>
    
    		<?php wp_reset_postdata(); ?>
		 
		<?php else : ?>
		    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
		<?php endif; 

	wp_die(); // this is required to terminate immediately and return a proper response
}


 */

get_header(); ?>

<?php
	
		$args1  = array('post_type' => 'post',
			   		   'posts_per_page'=> -1,

			   		  );

		// the query count posts
		$the_query = new WP_Query( $args1 ); 


		$args  = array('post_type' => 'post',
			   		   'paged'=>1,

			   		  );

		// the loop query
		$the_query = new WP_Query( $args ); ?>

	<div class="wrap" id="posts" data-count="<?php echo ceil($the_query->found_posts/2); ?>" >

		<?php if ( $the_query->have_posts() ) : ?>
    	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
       		<h2><?php the_title(); ?></h2>

   		 <?php endwhile; ?>
    
    <?php wp_reset_postdata(); ?>
 
<?php else : ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>
	
	</div>

	<div class="load-more">
			<button id="load-post" style="margin-left: 350px;">Load our new post</button>
	</div>
		

<?php  get_footer(); ?>