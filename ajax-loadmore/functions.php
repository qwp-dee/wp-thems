<?php 


/*loadmore scripts loading*/
function load_js_fn(){

 wp_enqueue_script('wp-ajax',  get_template_directory_uri() .'/js/postajax.php', false, '', true);
 wp_localize_script('wp-ajax', 'wp_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

}
add_action( 'wp_enqueue_scripts', 'stokedagency_themes_scripts_fn' );


/*Load more posts*/
function loadmore_post() {
	ob_start();  ?>
	<div class="wrap">
		<div id="primary" class="content-area">
			<?php 
			$args = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'posts_per_page' => '9',
				'category__not_in' => 1366 , // Exclude events category from blog page.
				'paged' => 1,
			);
			$blog_posts = new WP_Query( $args );
			// echo "<pre>";
			// 	print_r($blog_posts);
			// echo "</pre>";
			
			?>
			<?php if ( $blog_posts->have_posts() ) : ?>
				<div class="posts_blocks">
					<?php while ( $blog_posts->have_posts() ) : $blog_posts->the_post(); ?>
						<div class="blog-posts">
							<div class="image">
								<?php 
									if( has_category('ceo-letters') ) {
										$CEO_letter_image = get_field( 'post_featured_image', get_the_ID() ); ?>
										<img src="<?php echo $CEO_letter_image[ 'url' ]; ?>" alt="" srcset="">
									<?php }
									else {
										echo get_the_post_thumbnail( get_the_ID(), 'large' ); 
									}
								?>
							</div>
							<h2 class="blog_title"><a href="<?php echo get_permalink();?>"><?php the_title(); ?></a></h2>
							<div class="blog_desc"><?php echo wp_trim_words( get_the_content(), 30, '...' ); ?></div>
							<div class="blog_info">
								<?php 
								// echo post_author
								// $author_id = get_post_field( 'post_author', get_the_ID() );
								// echo "id = " . $author_id; 
								?>
								<?php 
									// $author_data = get_userdata( $author_id );
									// echo "In";
									// echo "<pre>";
									// 	print_r($blog_posts);
									// echo "</pre>";
								?>
								<div class="blog_author">by <?php echo get_the_author_link(); ?></div>
								<div class="blog_date"><?php the_time(' F j,  Y'); ?></div>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
				<div class="loadmore"><span>Load More</span></div>
				<div class="no_post"><span class="no-more-post"></span></div>
			<?php endif; ?>
		</div>
  	</div>
  	<?php
	return ob_get_clean();
} 
add_shortcode( 'Postcontent', 'loadmore_post' );

function load_posts_by_ajax_callback() {
	$paged = $_POST['page'];
	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => '9',
		'category__not_in' => 1366 , // Exclude events category from blog page.
		'paged' => $paged,
	);



	$blog_posts = new WP_Query( $args ); ?>
	<?php if ( $blog_posts->have_posts() ) : ?>
		<?php while ( $blog_posts->have_posts() ) : $blog_posts->the_post(); ?>
			<div class="blog-posts">
				<div class="image">
					<?php 
						if( has_category('ceo-letters') ) {
							$CEO_letter_image = get_field( 'post_featured_image', get_the_ID() ); ?>
							<img src="<?php echo $CEO_letter_image[ 'url' ]; ?>" alt="" srcset="">
						<?php }
						else {
							echo get_the_post_thumbnail( get_the_ID(), 'large' ); 
						}
					?>
				</div>
				<h2 class="blog_title"><a href="<?php echo get_permalink();?>"><?php the_title(); ?></a></h2>
				<div class="blog_desc"><?php  echo wp_trim_words( get_the_content(), 30, '...' );?></div>
				<div class="blog_info">
					<div class="blog_author">by <?php echo get_the_author_link(); ?></div>
					<div class="blog_date"><?php the_time(' F j,  Y'); ?></div>
				</div>
			</div>
			<?php endwhile; 
	endif;
	wp_die();
}
add_action('wp_ajax_load_posts_by_ajax', 'load_posts_by_ajax_callback');
add_action('wp_ajax_nopriv_load_posts_by_ajax', 'load_posts_by_ajax_callback');